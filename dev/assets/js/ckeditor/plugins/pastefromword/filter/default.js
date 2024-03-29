﻿/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

/* globals CKEDITOR */

(function () {
    var List, Style, filter,
        tools = CKEDITOR.tools,
        invalidTags = [
            'o:p',
            'xml',
            'script',
            'meta',
            'link'
        ],
        links = {},
        inComment = 0;

    /**
     * Set of Paste from Word plugin helpers.
     *
     * @since 4.6.0
     * @private
     * @member CKEDITOR.plugins
     */
    CKEDITOR.plugins.pastefromword = {};

    CKEDITOR.cleanWord = function (mswordHtml, editor) {

        var msoListsDetected = Boolean(mswordHtml.match(/mso-list:\s*l\d+\s+level\d+\s+lfo\d+/));

        // Sometimes Word malforms the comments.
        mswordHtml = mswordHtml.replace(/<!\[/g, '<!--[').replace(/\]>/g, ']-->');

        var fragment = CKEDITOR.htmlParser.fragment.fromHtml(mswordHtml);

        filter = new CKEDITOR.htmlParser.filter({
            root: function (element) {
                element.filterChildren(filter);

                CKEDITOR.plugins.pastefromword.lists.cleanup(List.createLists(element));
            },
            elementNames: [
                [(/^\?xml:namespace$/), ''],
                [/^v:shapetype/, ''],
                [new RegExp(invalidTags.join('|')), ''] // Remove invalid tags.
            ],
            elements: {
                'a': function (element) {
                    // Redundant anchor created by IE8.
                    if (element.attributes.name) {
                        if (element.attributes.name == '_GoBack') {
                            delete element.name;
                            return;
                        }

                        // Garbage links that go nowhere.
                        if (element.attributes.name.match(/^OLE_LINK\d+$/)) {
                            delete element.name;
                            return;
                        }
                    }

                    if (element.attributes.href && element.attributes.href.match(/#.+$/)) {
                        var name = element.attributes.href.match(/#(.+)$/)[1];
                        links[name] = element;
                    }

                    if (element.attributes.name && links[element.attributes.name]) {
                        var link = links[element.attributes.name];
                        link.attributes.href = link.attributes.href.replace(/.*#(.*)$/, '#$1');
                    }

                },
                'div': function (element) {
                    Style.createStyleStack(element, filter, editor);
                },
                'img': function (element) {
                    var attributeStyleMap = {
                        width: function (value) {
                            Style.setStyle(element, 'width', value + 'px');
                        },
                        height: function (value) {
                            Style.setStyle(element, 'height', value + 'px');
                        }
                    };

                    if (element.parent) {
                        var attrs = element.parent.attributes,
                            style = attrs.style || attrs.STYLE;
                        if (style && style.match(/mso\-list:\s?Ignore/)) {
                            element.attributes['cke-ignored'] = true;
                        }
                    }

                    Style.mapStyles(element, attributeStyleMap);

                    if (element.attributes.src && element.attributes.src.match(/^file:\/\//) &&
                        element.attributes.alt && element.attributes.alt.match(/^https?:\/\//)) {
                        element.attributes.src = element.attributes.alt;
                    }
                },
                'p': function (element) {
                    element.filterChildren(filter);

                    if (element.attributes.style && element.attributes.style.match(/display:\s*none/i)) {
                        return false;
                    }

                    if (List.thisIsAListItem(element)) {
                        List.convertToFakeListItem(element);
                    } else {
                        // In IE list level information is stored in <p> elements inside <li> elements.
                        var container = element.getAscendant(function (element) {
                                return element.name == 'ul' || element.name == 'ol';
                            }),
                            style = tools.parseCssText(element.attributes.style);
                        if (container &&
                            !container.attributes['cke-list-level'] &&
                            style['mso-list'] &&
                            style['mso-list'].match(/level/)) {
                            container.attributes['cke-list-level'] = style['mso-list'].match(/level(\d+)/)[1];
                        }
                    }

                    Style.createStyleStack(element, filter, editor);
                },
                'pre': function (element) {
                    if (List.thisIsAListItem(element)) List.convertToFakeListItem(element);

                    Style.createStyleStack(element, filter, editor);
                },
                'h1': function (element) {
                    if (List.thisIsAListItem(element)) List.convertToFakeListItem(element);

                    Style.createStyleStack(element, filter, editor);
                },
                'font': function (element) {
                    if (element.getHtml().match(/^\s*$/)) {
                        new CKEDITOR.htmlParser.text(' ').insertAfter(element);
                        return false;
                    }

                    if (editor && editor.config.pasteFromWordRemoveFontStyles === true && element.attributes.size) {
                        // font[size] are still used by old IEs for font size.
                        delete element.attributes.size;
                    }

                    createAttributeStack(element, filter);
                },
                'ul': function (element) {
                    if (!msoListsDetected) {
                        // List should only be processed if we're sure we're working with Word. (#16593)
                        return;
                    }

                    // Edge case from 11683 - an unusual way to create a level 2 list.
                    if (element.parent.name == 'li' && tools.indexOf(element.parent.children, element) === 0) {
                        Style.setStyle(element.parent, 'list-style-type', 'none');
                    }

                    List.dissolveList(element);
                    return false;
                },
                'li': function (element) {
                    if (!msoListsDetected) {
                        return;
                    }

                    element.attributes.style = Style.normalizedStyles(element, editor);

                    Style.pushStylesLower(element);
                },
                'ol': function (element) {
                    if (!msoListsDetected) {
                        // List should only be processed if we're sure we're working with Word. (#16593)
                        return;
                    }

                    // Fix edge-case where when a list skips a level in IE11, the <ol> element
                    // is implicitly surrounded by a <li>.
                    if (element.parent.name == 'li' && tools.indexOf(element.parent.children, element) === 0) {
                        Style.setStyle(element.parent, 'list-style-type', 'none');
                    }

                    List.dissolveList(element);
                    return false;
                },
                'span': function (element) {
                    element.filterChildren(filter);

                    element.attributes.style = Style.normalizedStyles(element, editor);

                    if (!element.attributes.style ||
                        // Remove garbage bookmarks that disrupt the content structure.
                        element.attributes.style.match(/^mso\-bookmark:OLE_LINK\d+$/) ||
                        element.getHtml().match(/^(\s|&nbsp;)+$/)) {

                        // replaceWithChildren doesn't work in filters.
                        for (var i = element.children.length - 1; i >= 0; i--) {
                            element.children[i].insertAfter(element);
                        }
                        return false;
                    }

                    Style.createStyleStack(element, filter, editor);
                },
                'table': function (element) {
                    element._tdBorders = {};
                    element.filterChildren(filter);

                    var borderStyle, occurences = 0;
                    for (var border in element._tdBorders) {
                        if (element._tdBorders[border] > occurences) {
                            occurences = element._tdBorders[border];
                            borderStyle = border;
                        }
                    }

                    Style.setStyle(element, 'border', borderStyle);

                },
                'td': function (element) {

                    var ascendant = element.getAscendant('table'),
                        tdBorders = ascendant._tdBorders,
                        borderStyles = ['border', 'border-top', 'border-right', 'border-bottom', 'border-left'],
                        ascendantStyle = tools.parseCssText(ascendant.attributes.style);

                    // Sometimes the background is set for the whole table - move it to individual cells.
                    var background = ascendantStyle.background || ascendantStyle.BACKGROUND;
                    if (background) {
                        Style.setStyle(element, 'background', background, true);
                    }

                    var backgroundColor = ascendantStyle['background-color'] || ascendantStyle['BACKGROUND-COLOR'];
                    if (backgroundColor) {
                        Style.setStyle(element, 'background-color', backgroundColor, true);
                    }

                    var styles = tools.parseCssText(element.attributes.style);

                    for (var style in styles) {
                        var temp = styles[style];
                        delete styles[style];
                        styles[style.toLowerCase()] = temp;
                    }

                    // Count all border styles that occur in the table.
                    for (var i = 0; i < borderStyles.length; i++) {
                        if (styles[borderStyles[i]]) {
                            var key = styles[borderStyles[i]];
                            tdBorders[key] = tdBorders[key] ? tdBorders[key] + 1 : 1;
                        }
                    }

                    Style.pushStylesLower(element, {
                        'background': true
                    });
                },
                'v:imagedata': remove,
                // This is how IE8 presents images.
                'v:shape': function (element) {
                    // In chrome a <v:shape> element may be followed by an <img> element with the same content.
                    var duplicate = false;
                    element.parent.getFirst(function (child) {
                        if (child.name == 'img' &&
                            child.attributes &&
                            child.attributes['v:shapes'] == element.attributes.id) {
                            duplicate = true;
                        }
                    });

                    if (duplicate) return false;

                    var src = '';
                    element.forEach(function (child) {
                        if (child.attributes && child.attributes.src) {
                            src = child.attributes.src;
                        }
                    }, CKEDITOR.NODE_ELEMENT, true);

                    element.filterChildren(filter);

                    element.name = 'img';
                    element.attributes.src = element.attributes.src || src;

                    delete element.attributes.type;
                },

                'style': function () {
                    // We don't want to let any styles in. Firefox tends to add some.
                    return false;
                }
            },
            attributes: {
                'style': function (styles, element) {
                    // Returning false deletes the attribute.
                    return Style.normalizedStyles(element, editor) || false;
                },
                'class': function (classes) {
                    return falseIfEmpty(classes.replace(/msonormal|msolistparagraph\w*/ig, ''));
                },
                'cellspacing': remove,
                'cellpadding': remove,
                'border': remove,
                'valign': remove,
                'v:shapes': remove,
                'o:spid': remove
            },
            comment: function (element) {
                if (element.match(/\[if.* supportFields.*\]/)) {
                    inComment++;
                }
                if (element == '[endif]') {
                    inComment = inComment > 0 ? inComment - 1 : 0;
                }
                return false;
            },
            text: function (content) {
                if (inComment) {
                    return '';
                }
                return content.replace(/&nbsp;/g, ' ');
            }
        });

        var writer = new CKEDITOR.htmlParser.basicWriter();

        filter.applyTo(fragment);
        fragment.writeHtml(writer);

        return writer.getHtml();
    };

    /**
     * Namespace containing all the helper functions to work with styles.
     *
     * @private
     * @since 4.6.0
     * @member CKEDITOR.plugins.pastefromword
     */
    CKEDITOR.plugins.pastefromword.styles = {
        setStyle: function (element, key, value, dontOverwrite) {
            var styles = tools.parseCssText(element.attributes.style);

            if (dontOverwrite && styles[key]) {
                return;
            }

            if (value === '') {
                delete styles[key];
            } else {
                styles[key] = value;
            }

            element.attributes.style = CKEDITOR.tools.writeCssText(styles);
        },

        // Map attributes to styles.
        mapStyles: function (element, attributeStyleMap) {
            for (var attribute in attributeStyleMap) {
                if (element.attributes[attribute]) {
                    if (typeof attributeStyleMap[attribute] === 'function') {
                        attributeStyleMap[attribute](element.attributes[attribute]);
                    } else {
                        Style.setStyle(element, attributeStyleMap[attribute], element.attributes[attribute]);
                    }
                    delete element.attributes[attribute];
                }
            }
        },

        /**
         * Filters Word-specific styles for a given element. Also might filter additional styles
         * based on the `editor` configuration.
         *
         * @private
         * @param {CKEDITOR.htmlParser.element} element
         * @param {CKEDITOR.editor} editor
         * @member CKEDITOR.plugins.pastefromword.styles
         */
        normalizedStyles: function (element, editor) {

            // Some styles and style values are redundant, so delete them.
            var resetStyles = [
                    'background-color:transparent',
                    'border-image:none',
                    'color:windowtext',
                    'direction:ltr',
                    'mso-',
                    'text-indent',
                    'visibility:visible',
                    'div:border:none' // This one stays because #6241
                ],
                textStyles = [
                    'font-family',
                    'font',
                    'font-size',
                    'color',
                    'background-color',
                    'line-height',
                    'text-decoration'
                ],
                matchStyle = function () {
                    var keys = [];
                    for (var i = 0; i < arguments.length; i++) {
                        if (arguments[i]) {
                            keys.push(arguments[i]);
                        }
                    }

                    return tools.indexOf(resetStyles, keys.join(':')) !== -1;
                },
                removeFontStyles = editor && editor.config.pasteFromWordRemoveFontStyles === true;

            var styles = tools.parseCssText(element.attributes.style);

            if (element.name == 'cke:li') {
                // IE8 tries to emulate list indentation with a combination of
                // text-indent and left margin. Normalize this. Note that IE8 styles are uppercase.
                if (styles['TEXT-INDENT'] && styles.MARGIN) {
                    element.attributes['cke-indentation'] = List.getElementIndentation(element);
                    styles.MARGIN = styles.MARGIN.replace(/(([\w\.]+ ){3,3})[\d\.]+(\w+$)/, '$10$3');
                }

            }

            var keys = tools.objectKeys(styles);

            for (var i = 0; i < keys.length; i++) {
                var styleName = keys[i].toLowerCase(),
                    styleValue = styles[keys[i]],
                    indexOf = CKEDITOR.tools.indexOf,
                    toBeRemoved = removeFontStyles && indexOf(textStyles, styleName.toLowerCase()) !== -1;

                if (toBeRemoved || matchStyle(null, styleName, styleValue) ||
                    matchStyle(null, styleName.replace(/\-.*$/, '-')) ||
                    matchStyle(null, styleName) ||
                    matchStyle(element.name, styleName, styleValue) ||
                    matchStyle(element.name, styleName.replace(/\-.*$/, '-')) ||
                    matchStyle(element.name, styleName) ||
                    matchStyle(styleValue)
                ) {
                    delete styles[keys[i]];
                }
            }
            return CKEDITOR.tools.writeCssText(styles);
        },

        /**
         * Surrounds the element's children with a stack of spans, each one having one style
         * originally belonging to the element.
         *
         * @private
         * @param {CKEDITOR.htmlParser.element} element
         * @param {CKEDITOR.htmlParser.filter} filter
         * @param {CKEDITOR.editor} editor
         * @member CKEDITOR.plugins.pastefromword.styles
         */
        createStyleStack: function (element, filter, editor) {
            var i,
                children = [];

            element.filterChildren(filter);

            // Store element's children somewhere else.
            for (i = element.children.length - 1; i >= 0; i--) {
                children.unshift(element.children[i]);
                element.children[i].remove();
            }

            Style.sortStyles(element);

            // Create a stack of spans with each containing one style.
            var styles = tools.parseCssText(Style.normalizedStyles(element, editor)),
                innermostElement = element,
                styleTopmost = element.name === 'span'; // Ensure that the root element retains at least one style.

            for (var style in styles) {
                if (style.match(/margin|text\-align|width|border|padding/i)) {
                    continue;
                }

                if (styleTopmost) {
                    styleTopmost = false;
                    continue;
                }

                var newElement = new CKEDITOR.htmlParser.element('span');

                newElement.attributes.style = style + ':' + styles[style];

                innermostElement.add(newElement);
                innermostElement = newElement;

                delete styles[style];
            }

            if (JSON.stringify(styles) !== '{}') {
                element.attributes.style = CKEDITOR.tools.writeCssText(styles);
            } else {
                delete element.attributes.style;
            }

            // Add the stored children to the innermost span.
            for (i = 0; i < children.length; i++) {
                innermostElement.add(children[i]);
            }
        },

        // Some styles need to be stacked in a particular order to work properly.
        sortStyles: function (element) {
            var orderedStyles = [
                    'border',
                    'border-bottom',
                    'font-size',
                    'background'
                ],
                style = tools.parseCssText(element.attributes.style),
                keys = tools.objectKeys(style),
                sortedKeys = [],
                nonSortedKeys = [];

            // Divide styles into sorted and non-sorted, because Array.prototype.sort()
            // requires a transitive relation.
            for (var i = 0; i < keys.length; i++) {
                if (tools.indexOf(orderedStyles, keys[i].toLowerCase()) !== -1) {
                    sortedKeys.push(keys[i]);
                } else {
                    nonSortedKeys.push(keys[i]);
                }
            }

            // For styles in orderedStyles[] enforce the same order as in orderedStyles[].
            sortedKeys.sort(function (a, b) {
                var aIndex = tools.indexOf(orderedStyles, a.toLowerCase());
                var bIndex = tools.indexOf(orderedStyles, b.toLowerCase());

                return aIndex - bIndex;
            });

            keys = [].concat(sortedKeys, nonSortedKeys);

            var sortedStyles = {};

            for (i = 0; i < keys.length; i++) {
                sortedStyles[keys[i]] = style[keys[i]];
            }

            element.attributes.style = CKEDITOR.tools.writeCssText(sortedStyles);
        },

        // Moves the element's styles lower in the DOM hierarchy.
        // Returns true on success.
        pushStylesLower: function (element, exceptions) {
            if (!element.attributes.style ||
                element.children.length === 0) {
                return false;
            }

            exceptions = exceptions || {};

            // Entries ending with a dash match styles that start with
            // the entry name, e.g. 'border-' matches 'border-style', 'border-color' etc.
            var retainedStyles = {
                'list-style-type': true,
                'width': true,
                'border': true,
                'border-': true
            };

            var styles = tools.parseCssText(element.attributes.style);

            for (var style in styles) {
                if (style.toLowerCase() in retainedStyles ||
                    retainedStyles [style.toLowerCase().replace(/\-.*$/, '-')] ||
                    style.toLowerCase() in exceptions) {
                    continue;
                }

                var pushed = false;

                for (var i = 0; i < element.children.length; i++) {
                    var child = element.children[i];

                    if (child.type !== CKEDITOR.NODE_ELEMENT) {
                        continue;
                    }

                    pushed = true;

                    Style.setStyle(child, style, styles[style]);
                }

                if (pushed) {
                    delete styles[style];
                }
            }

            element.attributes.style = CKEDITOR.tools.writeCssText(styles);

            return true;
        }
    };
    Style = CKEDITOR.plugins.pastefromword.styles;

    /**
     * Namespace containing any list-oriented helper methods.
     *
     * @private
     * @since 4.6.0
     * @member CKEDITOR.plugins.pastefromword
     */
    CKEDITOR.plugins.pastefromword.lists = {
        /**
         * Checks if a given element is a list item-alike.
         *
         * @private
         * @param {CKEDITOR.htmlParser.element} element
         * @returns {Boolean}
         * @member CKEDITOR.plugins.pastefromword.lists
         */
        thisIsAListItem: function (element) {
            /*jshint -W024 */
            // Normally a style of the sort that looks like "mso-list: l0 level1 lfo1"
            // indicates a list element, but the same style may appear in a <p> that's within a <li>.
            if (((element.attributes.style && element.attributes.style.match(/mso\-list:\s?l\d/)) &&
                    element.parent.name !== 'li') ||
                element.attributes['cke-dissolved'] ||
                element.getHtml().match(/<!\-\-\[if !supportLists]\-\->/) ||
                // Flat, ordered lists are represented by paragraphs
                // who's text content roughly matches /(&nbsp;)*(.*?)(&nbsp;)+/
                // where the middle parentheses contain the symbol.
                element
                    .getHtml()
                    .match(/^( )*.*?[\.\)] ( ){2,666}/)
            ) {
                return true;
            }

            return false;
            /*jshint +W024 */
        },

        /**
         * Converts an element to an element with the `cke:li` tag name.
         *
         * @private
         * @param {CKEDITOR.htmlParser.element} element
         * @member CKEDITOR.plugins.pastefromword.lists
         */
        convertToFakeListItem: function (element) {
            // A dummy call to cache parsed list info inside of cke-list-* attributes.
            this.getListItemInfo(element);

            if (!element.attributes['cke-dissolved']) {
                // The symbol is usually the first text node descendant
                // of the element that doesn't start with a whitespace character;
                var symbol;

                element.forEach(function (element) {
                    // Sometimes there are custom markers represented as images.
                    // They can be recognized by the distinctive alt attribute value.
                    if (!symbol && element.name == 'img' &&
                        element.attributes['cke-ignored'] &&
                        element.attributes.alt == '*') {
                        symbol = '·';
                        // Remove the "symbol" now, since it's the best opportunity to do so.
                        element.remove();
                    }
                }, CKEDITOR.NODE_ELEMENT);

                element.forEach(function (element) {
                    if (!symbol && !element.value.match(/^ /)) {
                        symbol = element.value;
                    }
                }, CKEDITOR.NODE_TEXT);

                // Without a symbol this isn't really a list item.
                if (typeof symbol == 'undefined') {
                    return;
                }

                element.attributes['cke-symbol'] = symbol.replace(/ .*$/, '');

                List.removeSymbolText(element);
            }


            if (element.attributes.style) {
                // Hacky way to get rid of margin left.
                // @todo: we should gather all css cleanup here, and consider bidi. Eventually we might put a config variable to
                // to enable it.
                var styles = tools.parseCssText(element.attributes.style);

                if (styles['margin-left']) {
                    delete styles['margin-left'];
                    element.attributes.style = CKEDITOR.tools.writeCssText(styles);
                }
            }

            // Converting to a normal list item would implicitly wrap the element around an <ul>.
            element.name = 'cke:li';
        },

        /**
         * Converts any fake list items contained within `root` into real `li` elements.
         *
         * @private
         * @param {CKEDITOR.htmlParser.element} root
         * @returns {CKEDITOR.htmlParser.element[]} An array of converted elements.
         * @member CKEDITOR.plugins.pastefromword.lists
         */
        convertToRealListItems: function (root) {
            var listElements = [];
            // Select and clean up list elements.
            root.forEach(function (element) {
                if (element.name == 'cke:li') {
                    element.name = 'li';

                    //List.removeSymbolText( element );

                    listElements.push(element);
                }
            }, CKEDITOR.NODE_ELEMENT, false);

            return listElements;
        },

        removeSymbolText: function (element) { // ...from a list element.
            var removed,
                symbol = element.attributes['cke-symbol'];

            element.forEach(function (node) {
                if (!removed && node.value.match(symbol.replace(')', '\\)').replace('(', ''))) {

                    node.value = node.value.replace(symbol, '');

                    if (node.parent.getHtml().match(/^(\s|&nbsp;)*$/)) {
                        removed = node.parent !== element ? node.parent : null;
                    }
                }
            }, CKEDITOR.NODE_TEXT);

            removed && removed.remove();
        },

        setListSymbol: function (list, symbol, level) {
            level = level || 1;

            var style = tools.parseCssText(list.attributes.style);

            if (list.name == 'ol') {
                if (list.attributes.type || style['list-style-type']) return;

                var typeMap = {
                    '[ivx]': 'lower-roman',
                    '[IVX]': 'upper-roman',
                    '[a-z]': 'lower-alpha',
                    '[A-Z]': 'upper-alpha',
                    '\\d': 'decimal'
                };

                for (var type in typeMap) {
                    if (List.getSubsectionSymbol(symbol).match(new RegExp(type))) {
                        style['list-style-type'] = typeMap[type];
                        break;
                    }
                }

                list.attributes['cke-list-style-type'] = style['list-style-type'];
            } else {
                var symbolMap = {
                    '·': 'disc',
                    'o': 'circle',
                    '§': 'square' // In Word this is a square.
                };

                if (!style['list-style-type'] && symbolMap[symbol]) {
                    style['list-style-type'] = symbolMap[symbol];
                }

            }

            List.setListSymbol.removeRedundancies(style, level);

            (list.attributes.style = CKEDITOR.tools.writeCssText(style)) || delete list.attributes.style;
        },

        setListStart: function (list) {
            var symbols = [],
                offset = 0;

            for (var i = 0; i < list.children.length; i++) {
                symbols.push(list.children[i].attributes['cke-symbol'] || '');
            }

            // When a list starts with a sublist, use the next element as a start indicator.
            if (!symbols[0]) {
                offset++;
            }

            // Attribute set in setListSymbol()
            switch (list.attributes['cke-list-style-type']) {
                case 'lower-roman':
                case 'upper-roman':
                    list.attributes.start = List.toArabic(List.getSubsectionSymbol(symbols[offset])) - offset;
                    break;
                case 'lower-alpha':
                case 'upper-alpha':
                    list.attributes.start = List.getSubsectionSymbol(symbols[offset]).replace(/\W/g, '').toLowerCase().charCodeAt(0) - 96 - offset;
                    break;
                case 'decimal':
                    list.attributes.start = (parseInt(List.getSubsectionSymbol(symbols[offset]), 10) - offset) || 1;
                    break;
            }

            if (list.attributes.start == '1') {
                delete list.attributes.start;
            }

            delete list.attributes['cke-list-style-type'];
        },

        numbering: {
            /**
             * Converts the list marker value into a decimal number.
             *
             *         var toNumber = CKEDITOR.plugins.pastefromword.lists.numbering.toNumber;
             *
             *         console.log( toNumber( 'XIV', 'upper-roman' ) ); // Logs 14.
             *         console.log( toNumber( 'd', 'lower-alpha' ) ); // Logs 4.
             *         console.log( toNumber( '35', 'decimal' ) ); // Logs 35.
             *         console.log( toNumber( '404', 'foo' ) ); // Logs 1.
             *
             * @param {String} marker
             * @param {String} markerType Marker type according to CSS `list-style-type` values.
             * @returns {Number}
             * @member CKEDITOR.plugins.pastefromword.lists.numbering
             */
            toNumber: function (marker, markerType) {
                // Functions copied straight from old PFW implementation, no need to reinvent the wheel.
                function fromAlphabet(str) {
                    var alpahbets = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

                    str = str.toUpperCase();
                    var l = alpahbets.length,
                        retVal = 1;
                    for (var x = 1; str.length > 0; x *= l) {
                        retVal += alpahbets.indexOf(str.charAt(str.length - 1)) * x;
                        str = str.substr(0, str.length - 1);
                    }
                    return retVal;
                }

                function fromRoman(str) {
                    var romans = [
                        [1000, 'M'],
                        [900, 'CM'],
                        [500, 'D'],
                        [400, 'CD'],
                        [100, 'C'],
                        [90, 'XC'],
                        [50, 'L'],
                        [40, 'XL'],
                        [10, 'X'],
                        [9, 'IX'],
                        [5, 'V'],
                        [4, 'IV'],
                        [1, 'I']
                    ];

                    str = str.toUpperCase();
                    var l = romans.length,
                        retVal = 0;
                    for (var i = 0; i < l; ++i) {
                        for (var j = romans[i], k = j[1].length; str.substr(0, k) == j[1]; str = str.substr(k))
                            retVal += j[0];
                    }
                    return retVal;
                }

                if (markerType == 'decimal') {
                    return Number(marker);
                } else if (markerType == 'upper-roman' || markerType == 'lower-roman') {
                    return fromRoman(marker.toUpperCase());
                } else if (markerType == 'lower-alpha' || markerType == 'upper-alpha') {
                    return fromAlphabet(marker);
                } else {
                    return 1;
                }
            },

            /**
             * Returns a list style based on the Word marker content.
             *
             *        var getStyle = CKEDITOR.plugins.pastefromword.lists.numbering.getStyle;
             *
             *        console.log( getStyle( '4' ) ); // Logs: "decimal"
             *        console.log( getStyle( 'b' ) ); // Logs: "lower-alpha"
             *        console.log( getStyle( 'P' ) ); // Logs: "upper-alpha"
             *        console.log( getStyle( 'i' ) ); // Logs: "lower-roman"
             *        console.log( getStyle( 'X' ) ); // Logs: "upper-roman"
             *
             *
             * **Implementation note:** Characters `c` and `d` are not converted to roman on purpose. It is 100 and 500 respectively, so
             * you rarely go with a list up until this point, while it is common to start with `c` and `d` in alpha.
             *
             * @param {String} marker Marker content retained from Word, e.g. `1`, `7`, `XI`, `b`.
             * @returns {String} Resolved marker type.
             * @member CKEDITOR.plugins.pastefromword.lists.numbering
             */
            getStyle: function (marker) {
                var typeMap = {
                        'i': 'lower-roman',
                        'v': 'lower-roman',
                        'x': 'lower-roman',
                        'l': 'lower-roman',
                        'm': 'lower-roman',
                        'I': 'upper-roman',
                        'V': 'upper-roman',
                        'X': 'upper-roman',
                        'L': 'upper-roman',
                        'M': 'upper-roman'
                    },
                    firstCharacter = marker.slice(0, 1),
                    type = typeMap[firstCharacter];

                if (!type) {
                    type = 'decimal';

                    if (firstCharacter.match(/[a-z]/)) {
                        type = 'lower-alpha';
                    }
                    if (firstCharacter.match(/[A-Z]/)) {
                        type = 'upper-alpha';
                    }
                }

                return type;
            }
        },

        // Taking into account cases like "1.1.2." etc. - get the last element.
        getSubsectionSymbol: function (symbol) {
            return (symbol.match(/([\da-zA-Z]+).?$/) || ['placeholder', 1])[1];
        },

        setListDir: function (list) {
            var dirs = {ltr: 0, rtl: 0};

            list.forEach(function (child) {
                if (child.name == 'li') {
                    var dir = child.attributes.dir || child.attributes.DIR || '';
                    if (dir.toLowerCase() == 'rtl') {
                        dirs.rtl++;
                    } else {
                        dirs.ltr++;
                    }
                }
            }, CKEDITOR.ELEMENT_NODE);

            if (dirs.rtl > dirs.ltr) {
                list.attributes.dir = 'rtl';
            }
        },

        createList: function (element) {
            // "o" symbolizes a circle in unordered lists.
            if ((element.attributes['cke-symbol'].match(/([\da-np-zA-NP-Z]).?/) || [])[1]) {
                return new CKEDITOR.htmlParser.element('ol');
            }
            return new CKEDITOR.htmlParser.element('ul');
        },

        /**
         * @private
         * @param {CKEDITOR.htmlParser.element} root An element to be looked through for lists.
         * @returns {CKEDITOR.htmlParser.element[]} An array of created list items.
         * @member CKEDITOR.plugins.pastefromword.lists
         */
        createLists: function (root) {
            var element, level, i, j,
                listElements = List.convertToRealListItems(root);

            if (listElements.length === 0) {
                return [];
            }


            // Chop data into continuous lists.
            var lists = List.groupLists(listElements);

            // Create nested list structures.
            for (i = 0; i < lists.length; i++) {
                var list = lists[i],
                    firstLevel1Element = list[0];

                // To determine the type of the top-level list a level 1 element is needed.
                for (j = 0; j < list.length; j++) {
                    if (list[j].attributes['cke-list-level'] == 1) {
                        firstLevel1Element = list[j];
                        break;
                    }
                }

                var containerStack = [List.createList(firstLevel1Element)],
                    // List wrapper (ol/ul).
                    innermostContainer = containerStack[0],
                    allContainers = [containerStack[0]];

                // Insert first known list item before the list wrapper.
                innermostContainer.insertBefore(list[0]);

                for (j = 0; j < list.length; j++) {
                    element = list[j];

                    level = element.attributes['cke-list-level'];

                    while (level > containerStack.length) {
                        var content = List.createList(element);

                        var children = innermostContainer.children;
                        if (children.length > 0) {
                            children[children.length - 1].add(content);
                        } else {
                            var container = new CKEDITOR.htmlParser.element('li', {
                                style: 'list-style-type:none'
                            });
                            container.add(content);
                            innermostContainer.add(container);
                        }

                        containerStack.push(content);
                        allContainers.push(content);
                        innermostContainer = content;

                        if (level == containerStack.length) {
                            List.setListSymbol(content, element.attributes['cke-symbol'], level);
                        }
                    }

                    while (level < containerStack.length) {
                        containerStack.pop();
                        innermostContainer = containerStack[containerStack.length - 1];

                        if (level == containerStack.length) {
                            List.setListSymbol(innermostContainer, element.attributes['cke-symbol'], level);
                        }
                    }

                    // For future reference this is where the list elements are actually put into the lists.
                    element.remove();
                    innermostContainer.add(element);
                }

                // Try to set the symbol for the root (level 1) list.
                var level1Symbol;
                if (containerStack[0].children.length) {
                    level1Symbol = containerStack[0].children[0].attributes['cke-symbol'];

                    if (!level1Symbol && containerStack[0].children.length > 1) {
                        level1Symbol = containerStack[0].children[1].attributes['cke-symbol'];
                    }

                    if (level1Symbol) {
                        List.setListSymbol(containerStack[0], level1Symbol);
                    }
                }

                // This can be done only after all the list elements are where they should be.
                for (j = 0; j < allContainers.length; j++) {
                    List.setListStart(allContainers[j]);
                }

                // Last but not least apply li[start] if needed, also this needs to be done once ols are final.
                for (j = 0; j < list.length; j++) {
                    this.determineListItemValue(list[j]);
                }
            }

            return listElements;
        },

        /**
         * Final cleanup &mdash; removes all `cke-*` helper attributes.
         *
         * @private
         * @param {CKEDITOR.htmlParser.element[]} listElements
         * @member CKEDITOR.plugins.pastefromword.lists
         */
        cleanup: function (listElements) {
            var tempAttributes = [
                    'cke-list-level',
                    'cke-symbol',
                    'cke-list-id',
                    'cke-indentation',
                    'cke-dissolved'
                ],
                i,
                j;

            for (i = 0; i < listElements.length; i++) {
                for (j = 0; j < tempAttributes.length; j++) {
                    delete listElements[i].attributes[tempAttributes[j]];
                }
            }
        },

        /**
         * Tries to determine the `li[value]` attribute for a given list item. The `element` given must
         * have a parent in order for this function to work properly.
         *
         * @private
         * @param {CKEDITOR.htmlParser.element} element
         * @member CKEDITOR.plugins.pastefromword.lists
         */
        determineListItemValue: function (element) {
            if (element.parent.name !== 'ol') {
                // li[value] make sense only for list items in ordered list.
                return;
            }

            var assumedValue = this.calculateValue(element),
                cleanSymbol = element.attributes['cke-symbol'].match(/[a-z0-9]+/gi),
                computedValue,
                listType;

            if (cleanSymbol) {
                // Note that we always want to use last match, just because of markers like "1.1.4" "1.A.a.IV" etc.
                cleanSymbol = cleanSymbol[cleanSymbol.length - 1];

                // We can determine proper value only if we know what type of list is it.
                // So we need to check list wrapper if it has this information.
                listType = element.parent.attributes['cke-list-style-type'] || this.numbering.getStyle(cleanSymbol);

                computedValue = this.numbering.toNumber(cleanSymbol, listType);

                if (computedValue !== assumedValue) {
                    element.attributes.value = computedValue;
                }
            }
        },

        /**
         * Calculates the value for a given `<li>` element based on its precedent list items (e.g. the `value`
         * attribute). It could also look at the list parent (`<ol>`) at its start attribute.
         *
         * @private
         * @param {CKEDITOR.htmlParser.element} element The `<li>` element.
         * @returns {Number}
         * @member CKEDITOR.plugins.pastefromword.lists
         */
        calculateValue: function (element) {
            if (!element.parent) {
                return 1;
            }

            var list = element.parent,
                elementIndex = element.getIndex(),
                valueFound = null,
                // Index of the element with value attribute.
                valueElementIndex,
                curElement,
                i;

            // Look for any preceding li[value].
            for (i = elementIndex; i >= 0 && valueFound === null; i--) {
                curElement = list.children[i];

                if (curElement.attributes && curElement.attributes.value !== undefined) {
                    valueElementIndex = i;
                    valueFound = parseInt(curElement.attributes.value, 10);
                }
            }

            // Still if no li[value] was found, we'll check the list.
            if (valueFound === null) {
                valueFound = list.attributes.start !== undefined ? parseInt(list.attributes.start, 10) : 1;
                valueElementIndex = 0;
            }

            return valueFound + (elementIndex - valueElementIndex);
        },

        /**
         * @private
         * @param {CKEDITOR.htmlParser.element} element
         * @member CKEDITOR.plugins.pastefromword.lists
         */
        dissolveList: function (element) {
            var i, children = [],
                deletedLists = [];

            element.forEach(function (child) {
                if (child.name == 'li') {
                    var childChild = child.children[0];
                    if (childChild && childChild.name && childChild.attributes.style && childChild.attributes.style.match(/mso-list:/i)) {
                        Style.pushStylesLower(child, {'list-style-type': true, 'display': true});

                        var childStyle = tools.parseCssText(childChild.attributes.style, true);

                        Style.setStyle(child, 'mso-list', childStyle['mso-list'], true);
                        Style.setStyle(childChild, 'mso-list', '');

                        // If this style has a value it's usually "none". This marks such list elements for deletion.
                        if (childStyle.display || childStyle.DISPLAY) {
                            if (childStyle.display) {
                                Style.setStyle(child, 'display', childStyle.display, true);
                            } else {
                                Style.setStyle(child, 'display', childStyle.DISPLAY, true);
                            }
                        }
                    }

                    if (child.attributes.style && child.attributes.style.match(/mso-list:/i)) {
                        child.name = 'p';

                        child.attributes['cke-dissolved'] = true;

                        children.push(child);
                    }
                }

                // This fragment seems to look for nested lists and create cke-symbol attribute based on list type.
                if (child.name == 'ul' || child.name == 'ol') {
                    for (var i = 0; i < child.children.length; i++) {
                        if (child.children[i].name == 'li') {
                            var symbol,
                                type = child.attributes.type,
                                start = parseInt(child.attributes.start, 10) || 1;

                            if (!type) {
                                var style = tools.parseCssText(child.attributes.style);
                                type = style['list-style-type'];
                            }

                            switch (type) {
                                case 'disc':
                                    symbol = '·';
                                    break;
                                case 'circle':
                                    symbol = 'o';
                                    break;
                                case 'square':
                                    symbol = '§';
                                    break;
                                case '1':
                                case 'decimal':
                                    symbol = (start + i) + '.';
                                    break;
                                case 'a':
                                case 'lower-alpha':
                                    symbol = String.fromCharCode('a'.charCodeAt(0) + start - 1 + i) + '.';
                                    break;
                                case 'A':
                                case 'upper-alpha':
                                    symbol = String.fromCharCode('A'.charCodeAt(0) + start - 1 + i) + '.';
                                    break;
                                case 'i':
                                case 'lower-roman':
                                    symbol = toRoman(start + i) + '.';
                                    break;
                                case 'I':
                                case 'upper-roman':
                                    symbol = toRoman(start + i).toUpperCase() + '.';
                                    break;
                                default:
                                    symbol = child.name == 'ul' ? '·' : (start + i) + '.';
                            }

                            child.children[i].attributes['cke-symbol'] = symbol;
                        }
                    }

                    deletedLists.push(child);
                }
            }, CKEDITOR.NODE_ELEMENT, false);

            for (i = children.length - 1; i >= 0; i--) {
                children[i].insertAfter(element);
            }
            for (i = deletedLists.length - 1; i >= 0; i--) {
                delete deletedLists[i].name;
            }

            function toRoman(number) {
                if (number >= 50) return 'l' + toRoman(number - 50);
                if (number >= 40) return 'xl' + toRoman(number - 40);
                if (number >= 10) return 'x' + toRoman(number - 10);
                if (number == 9) return 'ix';
                if (number >= 5) return 'v' + toRoman(number - 5);
                if (number == 4) return 'iv';
                if (number >= 1) return 'i' + toRoman(number - 1);
                return '';
            }
        },

        groupLists: function (listElements) {
            // Chop data into continuous lists.
            var i, element,
                lists = [[listElements[0]]],
                lastList = lists[0];

            element = listElements[0];
            element.attributes['cke-indentation'] = element.attributes['cke-indentation'] || List.getElementIndentation(element);

            for (i = 1; i < listElements.length; i++) {
                element = listElements[i];
                var previous = listElements[i - 1];

                element.attributes['cke-indentation'] = element.attributes['cke-indentation'] || List.getElementIndentation(element);

                if (element.previous !== previous) {
                    List.chopDiscontinuousLists(lastList, lists);
                    lists.push(lastList = []);
                }

                lastList.push(element);
            }

            List.chopDiscontinuousLists(lastList, lists);

            return lists;
        },

        /**
         * Converts a single, flat list items array into an array with a hierarchy of items.
         *
         * As the list gets chopped, it will be forced to render as a separate list, even if it has a deeper nesting level.
         * For example, for level 3 it will create a structure like `ol > li > ol > li > ol > li`.
         *
         * Note that list items within a single list but with different levels that did not get chopped
         * will still be rendered as a list tree later.
         *
         * @private
         * @param {CKEDITOR.htmlParser.element[]} list An array containing list items.
         * @param {CKEDITOR.htmlParser.element[]} lists All the lists in the pasted content represented by an array of arrays
         * of list items. Modified by this method.
         * @member CKEDITOR.plugins.pastefromword.lists
         */
        chopDiscontinuousLists: function (list, lists) {
            var levelSymbols = {};
            var choppedLists = [[]],
                lastListInfo;

            for (var i = 0; i < list.length; i++) {
                var lastSymbol = levelSymbols[list[i].attributes['cke-list-level']],
                    currentListInfo = this.getListItemInfo(list[i]),
                    currentSymbol,
                    forceType;

                if (lastSymbol) {
                    // An "h" before an "i".
                    forceType = lastSymbol.type.match(/alpha/) && lastSymbol.index == 7 ? 'alpha' : forceType;
                    // An "n" before an "o".
                    forceType = list[i].attributes['cke-symbol'] == 'o' && lastSymbol.index == 14 ? 'alpha' : forceType;

                    currentSymbol = List.getSymbolInfo(list[i].attributes['cke-symbol'], forceType);
                    currentListInfo = this.getListItemInfo(list[i]);

                    // Based on current and last index we'll decide if we want to chop list.
                    if (
                        // If the last list was a different list type then chop it!
                    lastSymbol.type != currentSymbol.type ||
                    // If those are logically different lists, and current list is not a continuation (#7918):
                    (lastListInfo && currentListInfo.id != lastListInfo.id && !this.isAListContinuation(list[i]))) {
                        choppedLists.push([]);
                    }
                } else {
                    currentSymbol = List.getSymbolInfo(list[i].attributes['cke-symbol']);
                }

                // Reset all higher levels
                for (var j = parseInt(list[i].attributes['cke-list-level'], 10) + 1; j < 20; j++) {
                    if (levelSymbols[j]) {
                        delete levelSymbols[j];
                    }
                }

                levelSymbols[list[i].attributes['cke-list-level']] = currentSymbol;
                choppedLists[choppedLists.length - 1].push(list[i]);

                lastListInfo = currentListInfo;
            }

            [].splice.apply(lists, [].concat([tools.indexOf(lists, list), 1], choppedLists));
        },

        /**
         * Checks if this list is a direct continuation of a list interrupted by a list with a different ID,
         * with a different level. So if you look at a following list:
         *
         * * list1 level1
         * * list1 level1
         *        * list2 level2
         *        * list2 level2
         * * list1 level1
         *
         * It would return `true` &mdash; meaning it is a continuation, and should not be chopped. However, if any paragraph or
         * anything else appears in between, it should be broken into different lists.
         *
         * You can see fixtures from issue #7918 as an example.
         *
         * @private
         * @param {CKEDITOR.htmlParser.element} listElement The list to be checked.
         * @returns {Boolean}
         * @member CKEDITOR.plugins.pastefromword.lists
         */
        isAListContinuation: function (listElement) {
            var prev = listElement;

            do {
                prev = prev.previous;

                if (prev && prev.type === CKEDITOR.NODE_ELEMENT) {
                    if (prev.attributes['cke-list-level'] === undefined) {
                        // Not a list, so looks like an interrupted list.
                        return false;
                    }

                    if (prev.attributes['cke-list-level'] === listElement.attributes['cke-list-level']) {
                        // Same level, so we want to check if this is a continuation.
                        return prev.attributes['cke-list-id'] === listElement.attributes['cke-list-id'];
                    }
                }

            } while (prev);

            return false;
        },

        getElementIndentation: function (element) {
            var style = tools.parseCssText(element.attributes.style);

            if (style.margin || style.MARGIN) {
                style.margin = style.margin || style.MARGIN;
                var fakeElement = {
                    styles: {
                        margin: style.margin
                    }
                };
                CKEDITOR.filter.transformationsTools.splitMarginShorthand(fakeElement);
                style['margin-left'] = fakeElement.styles['margin-left'];
            }

            return parseInt(tools.convertToPx(style['margin-left'] || '0px'), 10);
        },

        // Source: http://stackoverflow.com/a/17534350/3698944
        toArabic: function (symbol) {
            if (!symbol.match(/[ivxl]/i)) return 0;
            if (symbol.match(/^l/i)) return 50 + List.toArabic(symbol.slice(1));
            if (symbol.match(/^lx/i)) return 40 + List.toArabic(symbol.slice(1));
            if (symbol.match(/^x/i)) return 10 + List.toArabic(symbol.slice(1));
            if (symbol.match(/^ix/i)) return 9 + List.toArabic(symbol.slice(2));
            if (symbol.match(/^v/i)) return 5 + List.toArabic(symbol.slice(1));
            if (symbol.match(/^iv/i)) return 4 + List.toArabic(symbol.slice(2));
            if (symbol.match(/^i/i)) return 1 + List.toArabic(symbol.slice(1));
            // Ignore other characters.
            return List.toArabic(symbol.slice(1));
        },

        /**
         * Returns an object describing the given `symbol`.
         *
         * @private
         * @param {String} symbol
         * @param {String} type
         * @returns {Object} ret
         * @returns {Number} ret.index Identified numbering value
         * @returns {String} ret.type One of `decimal`, `disc`, `circle`, `square`, `roman`, `alpha`.
         * @member CKEDITOR.plugins.pastefromword.lists
         */
        getSymbolInfo: function (symbol, type) {
            var symbolCase = symbol.toUpperCase() == symbol ? 'upper-' : 'lower-',
                symbolMap = {
                    '·': ['disc', -1],
                    'o': ['circle', -2],
                    '§': ['square', -3]
                };

            if (symbol in symbolMap || (type && type.match(/(disc|circle|square)/))) {
                return {
                    index: symbolMap[symbol][1],
                    type: symbolMap[symbol][0]
                };
            }

            if (symbol.match(/\d/)) {
                return {
                    index: symbol ? parseInt(List.getSubsectionSymbol(symbol), 10) : 0,
                    type: 'decimal'
                };
            }

            symbol = symbol.replace(/\W/g, '').toLowerCase();

            if ((!type && symbol.match(/[ivxl]+/i)) || (type && type != 'alpha') || type == 'roman') {
                return {
                    index: List.toArabic(symbol),
                    type: symbolCase + 'roman'
                };
            }

            if (symbol.match(/[a-z]/i)) {
                return {
                    index: symbol.charCodeAt(0) - 97,
                    type: symbolCase + 'alpha'
                };
            }

            return {
                index: -1,
                type: 'disc'
            };
        },

        /**
         * Returns Word-generated information about the given list item, mainly by parsing the `mso-list`
         * CSS property.
         *
         * Note: Paragraphs with `mso-list` are also counted as list items because Word serves
         * list items as paragraphs.
         *
         * @private
         * @param {CKEDITOR.htmlParser.element} list
         * @returns ret
         * @returns {String} ret.id List ID. Usually it is a decimal string.
         * @returns {String} ret.level List nesting level, `0` means it is the outermost list. Usually it is
         * a decimal string.
         * @member CKEDITOR.plugins.pastefromword.lists
         */
        getListItemInfo: function (list) {
            if (list.attributes['cke-list-id'] !== undefined) {
                // List was already resolved.
                return {
                    id: list.attributes['cke-list-id'],
                    level: list.attributes['cke-list-level']
                };
            }

            var propValue = tools.parseCssText(list.attributes.style)['mso-list'],
                ret = {
                    id: '0',
                    level: '1'
                };

            if (propValue) {
                // Add one whitespace so it's easier to match values assuming that all of these are separated with \s.
                propValue += ' ';

                ret.level = propValue.match(/level(.+?)\s+/)[1];
                ret.id = propValue.match(/l(\d+?)\s+/)[1];
            }

            // Store values. List level will be reused if present to prevent regressions.
            list.attributes['cke-list-level'] = list.attributes['cke-list-level'] !== undefined ? list.attributes['cke-list-level'] : ret.level;
            list.attributes['cke-list-id'] = ret.id;

            return ret;
        }
    };
    List = CKEDITOR.plugins.pastefromword.lists;

    // Expose this function since it's useful in other places.
    List.setListSymbol.removeRedundancies = function (style, level) {
        // 'disc' and 'decimal' are the default styles in some cases - remove redundancy.
        if ((level === 1 && style['list-style-type'] === 'disc') || style['list-style-type'] === 'decimal') {
            delete style['list-style-type'];
        }
    };

    function falseIfEmpty(value) {
        if (value === '') {
            return false;
        }
        return value;
    }

    // Used when filtering attributes - returning false deletes the attribute.
    function remove() {
        return false;
    }

    // Same as createStyleStack, but instead of styles - stack attributes.
    function createAttributeStack(element, filter) {
        var i,
            children = [];

        element.filterChildren(filter);

        // Store element's children somewhere else.
        for (i = element.children.length - 1; i >= 0; i--) {
            children.unshift(element.children[i]);
            element.children[i].remove();
        }

        // Create a stack of spans with each containing one style.
        var attributes = element.attributes,
            innermostElement = element,
            topmost = true;

        for (var attribute in attributes) {

            if (topmost) {
                topmost = false;
                continue;
            }

            var newElement = new CKEDITOR.htmlParser.element(element.name);

            newElement.attributes[attribute] = attributes[attribute];

            innermostElement.add(newElement);
            innermostElement = newElement;

            delete attributes[attribute];
        }

        // Add the stored children to the innermost span.
        for (i = 0; i < children.length; i++) {
            innermostElement.add(children[i]);
        }
    }

    CKEDITOR.plugins.pastefromword.createAttributeStack = createAttributeStack;

    /**
     * Numbering helper.
     *
     * @property {CKEDITOR.plugins.pastefromword.lists.numbering} numbering
     * @member CKEDITOR.plugins.pastefromword.lists
     */

    /**
     * Whether to ignore all font-related formatting styles, including:
     *
     * * font size;
     * * font family;
     * * font foreground and background color.
     *
     *        config.pasteFromWordRemoveFontStyles = true;
     *
     * **Important note:** Prior to version 4.6.0 this configuration option defaulted to `true`.
     *
     * @deprecated 4.6.0 Either configure proper [Advanced Content Filter](#!/guide/dev_advanced_content_filter) for the editor
     * or use the {@link CKEDITOR.editor#afterPasteFromWord} event.
     * @since 3.1
     * @cfg {Boolean} [pasteFromWordRemoveFontStyles=false]
     * @member CKEDITOR.config
     */

    /**
     * Whether to transform Microsoft Word outline numbered headings into lists.
     *
     *        config.pasteFromWordNumberedHeadingToList = true;
     *
     * @removed 4.6.0
     * @since 3.1
     * @cfg {Boolean} [pasteFromWordNumberedHeadingToList=false]
     * @member CKEDITOR.config
     */

    /**
     * Whether to remove element styles that cannot be managed with the editor. Note
     * that this option does not handle font-specific styles, which depend on the
     * {@link #pasteFromWordRemoveFontStyles} setting instead.
     *
     *        config.pasteFromWordRemoveStyles = false;
     *
     * @removed 4.6.0
     * @since 3.1
     * @cfg {Boolean} [pasteFromWordRemoveStyles=true]
     * @member CKEDITOR.config
     */
})();
