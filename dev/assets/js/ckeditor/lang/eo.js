/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

/**
 * @fileOverview Defines the {@link CKEDITOR.lang} object, for the
 * Esperanto language.
 */

/**#@+
 @type String
 @example
 */

/**
 * Contains the dictionary of language entries.
 * @namespace
 */
CKEDITOR.lang['eo'] = {
    // ARIA description.
    editor: 'RiĉTeksta Redaktilo',
    editorPanel: 'Panelo de la RiĉTeksta Redaktilo',

    // Common messages and labels.
    common: {
        // Screenreader titles. Please note that screenreaders are not always capable
        // of reading non-English words. So be careful while translating it.
        editorHelp: 'Premu ALT 0 por helpilo',

        browseServer: 'Foliumi en la Servilo',
        url: 'URL',
        protocol: 'Protokolo',
        upload: 'Alŝuti',
        uploadSubmit: 'Sendu al Servilo',
        image: 'Bildo',
        flash: 'Flaŝo',
        form: 'Formularo',
        checkbox: 'Markobutono',
        radio: 'Radiobutono',
        textField: 'Teksta kampo',
        textarea: 'Teksta Areo',
        hiddenField: 'Kaŝita Kampo',
        button: 'Butono',
        select: 'Elekta Kampo',
        imageButton: 'Bildbutono',
        notSet: '<Defaŭlta>',
        id: 'Id',
        name: 'Nomo',
        langDir: 'Skribdirekto',
        langDirLtr: 'De maldekstro dekstren (LTR)',
        langDirRtl: 'De dekstro maldekstren (RTL)',
        langCode: 'Lingva Kodo',
        longDescr: 'URL de Longa Priskribo',
        cssClass: 'Klasoj de Stilfolioj',
        advisoryTitle: 'Priskriba Titolo',
        cssStyle: 'Stilo',
        ok: 'Akcepti',
        cancel: 'Rezigni',
        close: 'Fermi',
        preview: 'Vidigi Aspekton',
        resize: 'Movigi por ŝanĝi la grandon',
        generalTab: 'Ĝenerala',
        advancedTab: 'Speciala',
        validateNumberFailed: 'Tiu valoro ne estas nombro.',
        confirmNewPage: 'La neregistritaj ŝanĝoj estas perdotaj. Ĉu vi certas, ke vi volas ŝargi novan paĝon?',
        confirmCancel: 'Iuj opcioj esta ŝanĝitaj. Ĉu vi certas, ke vi volas fermi la dialogon?',
        options: 'Opcioj',
        target: 'Celo',
        targetNew: 'Nova Fenestro (_blank)',
        targetTop: 'Supra Fenestro (_top)',
        targetSelf: 'Sama Fenestro (_self)',
        targetParent: 'Patra Fenestro (_parent)',
        langDirLTR: 'De maldekstro dekstren (LTR)',
        langDirRTL: 'De dekstro maldekstren (RTL)',
        styles: 'Stilo',
        cssClasses: 'Stilfoliaj Klasoj',
        width: 'Larĝo',
        height: 'Alto',
        align: 'Ĝisrandigo',
        alignLeft: 'Maldekstre',
        alignRight: 'Dekstre',
        alignCenter: 'Centre',
        alignJustify: 'Ĝisrandigi Ambaŭflanke',
        alignTop: 'Supre',
        alignMiddle: 'Centre',
        alignBottom: 'Malsupre',
        alignNone: 'Neniu',
        invalidValue: 'Nevalida Valoro',
        invalidHeight: 'Alto devas esti nombro.',
        invalidWidth: 'Larĝo devas esti nombro.',
        invalidCssLength: 'La valoro indikita por la "%1" kampo devas esti pozitiva nombro kun aŭ sen valida CSSmezurunuo (px, %, in, cm, mm, em, ex, pt, or pc).',
        invalidHtmlLength: 'La valoro indikita por la "%1" kampo devas esti pozitiva nombro kun aŭ sen valida HTMLmezurunuo (px or %).',
        invalidInlineStyle: 'La valoro indikita por la enlinia stilo devas konsisti el unu aŭ pluraj elementoj kun la formato de "nomo : valoro", apartigitaj per punktokomoj.',
        cssLengthTooltip: 'Entajpu nombron por rastrumera valoro aŭ nombron kun valida CSSunuo (px, %, in, cm, mm, em, ex, pt, or pc).',

        // Put the voice-only part of the label in the span.
        unavailable: '%1<span class="cke_accessibility">, nehavebla</span>',

        // Keyboard keys translations used for creating shortcuts descriptions in tooltips, context menus and ARIA labels.
        keyboard: {
            8: 'Retropaŝo',
            13: 'Enigi',
            16: 'Registrumo',
            17: 'Stirklavo',
            18: 'Alt-klavo',
            32: 'Space', // MISSING
            35: 'Fino',
            36: 'Hejmo',
            46: 'Forigi',
            224: 'Command' // MISSING
        },

        // Prepended to ARIA labels with shortcuts.
        keyboardShortcut: 'Keyboard shortcut' // MISSING
    }
};
