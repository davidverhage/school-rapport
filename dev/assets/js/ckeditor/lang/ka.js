/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

/**
 * @fileOverview Defines the {@link CKEDITOR.lang} object, for the Georgian
 *        language.
 */

/**#@+
 @type String
 @example
 */

/**
 * Contains the dictionary of language entries.
 * @namespace
 */
CKEDITOR.lang['ka'] = {
    // ARIA description.
    editor: 'ტექსტის რედაქტორი',
    editorPanel: 'Rich Text Editor panel', // MISSING

    // Common messages and labels.
    common: {
        // Screenreader titles. Please note that screenreaders are not always capable
        // of reading non-English words. So be careful while translating it.
        editorHelp: 'დააჭირეთ ALT 0-ს დახმარების მისაღებად',

        browseServer: 'სერვერზე დათვალიერება',
        url: 'URL',
        protocol: 'პროტოკოლი',
        upload: 'ატვირთვა',
        uploadSubmit: 'სერვერზე გაგზავნა',
        image: 'სურათი',
        flash: 'Flash',
        form: 'ფორმა',
        checkbox: 'მონიშვნის ღილაკი',
        radio: 'ამორჩევის ღილაკი',
        textField: 'ტექსტური ველი',
        textarea: 'ტექსტური არე',
        hiddenField: 'მალული ველი',
        button: 'ღილაკი',
        select: 'არჩევის ველი',
        imageButton: 'სურათიანი ღილაკი',
        notSet: '<არაფერი>',
        id: 'Id',
        name: 'სახელი',
        langDir: 'ენის მიმართულება',
        langDirLtr: 'მარცხნიდან მარჯვნივ (LTR)',
        langDirRtl: 'მარჯვნიდან მარცხნივ (RTL)',
        langCode: 'ენის კოდი',
        longDescr: 'დიდი აღწერის URL',
        cssClass: 'CSS კლასი',
        advisoryTitle: 'სათაური',
        cssStyle: 'CSS სტილი',
        ok: 'დიახ',
        cancel: 'გაუქმება',
        close: 'დახურვა',
        preview: 'გადახედვა',
        resize: 'გაწიე ზომის შესაცვლელად',
        generalTab: 'ინფორმაცია',
        advancedTab: 'გაფართოებული',
        validateNumberFailed: 'ეს მნიშვნელობა არაა რიცხვი.',
        confirmNewPage: 'ამ დოკუმენტში ყველა ჩაუწერელი ცვლილება დაიკარგება. დარწმუნებული ხართ რომ ახალი გვერდის ჩატვირთვა გინდათ?',
        confirmCancel: 'ზოგიერთი პარამეტრი შეცვლილია, დარწმუნებულილ ხართ რომ ფანჯრის დახურვა გსურთ?',
        options: 'პარამეტრები',
        target: 'გახსნის ადგილი',
        targetNew: 'ახალი ფანჯარა (_blank)',
        targetTop: 'ზედა ფანჯარა (_top)',
        targetSelf: 'იგივე ფანჯარა (_self)',
        targetParent: 'მშობელი ფანჯარა (_parent)',
        langDirLTR: 'მარცხნიდან მარჯვნივ (LTR)',
        langDirRTL: 'მარჯვნიდან მარცხნივ (RTL)',
        styles: 'სტილი',
        cssClasses: 'CSS კლასი',
        width: 'სიგანე',
        height: 'სიმაღლე',
        align: 'სწორება',
        alignLeft: 'მარცხენა',
        alignRight: 'მარჯვენა',
        alignCenter: 'შუა',
        alignJustify: '両端揃え',
        alignTop: 'ზემოთა',
        alignMiddle: 'შუა',
        alignBottom: 'ქვემოთა',
        alignNone: 'None', // MISSING
        invalidValue: 'Invalid value.', // MISSING
        invalidHeight: 'სიმაღლე რიცხვით უნდა იყოს წარმოდგენილი.',
        invalidWidth: 'სიგანე რიცხვით უნდა იყოს წარმოდგენილი.',
        invalidCssLength: 'Value specified for the "%1" field must be a positive number with or without a valid CSS measurement unit (px, %, in, cm, mm, em, ex, pt, or pc).', // MISSING
        invalidHtmlLength: 'Value specified for the "%1" field must be a positive number with or without a valid HTML measurement unit (px or %).', // MISSING
        invalidInlineStyle: 'Value specified for the inline style must consist of one or more tuples with the format of "name : value", separated by semi-colons.', // MISSING
        cssLengthTooltip: 'Enter a number for a value in pixels or a number with a valid CSS unit (px, %, in, cm, mm, em, ex, pt, or pc).', // MISSING

        // Put the voice-only part of the label in the span.
        unavailable: '%1<span class="cke_accessibility">, მიუწვდომელია</span>',

        // Keyboard keys translations used for creating shortcuts descriptions in tooltips, context menus and ARIA labels.
        keyboard: {
            8: 'Backspace', // MISSING
            13: 'Enter', // MISSING
            16: 'Shift', // MISSING
            17: 'Ctrl', // MISSING
            18: 'Alt', // MISSING
            32: 'Space', // MISSING
            35: 'End', // MISSING
            36: 'Home', // MISSING
            46: 'Delete', // MISSING
            224: 'Command' // MISSING
        },

        // Prepended to ARIA labels with shortcuts.
        keyboardShortcut: 'Keyboard shortcut' // MISSING
    }
};
