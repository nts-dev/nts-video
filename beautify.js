function beautify() {
    var TokenIterator = require("ace/token_iterator").TokenIterator;
    var iterator = new TokenIterator(editor.getSession(), 0, 0);
    var token = iterator.getCurrentToken();

    var code = '';

    var newLines = [{
        type: 'support.php_tag',
        value: '<?php'
    }, {
        type: 'support.php_tag',
        value: '<?'
    }, {
        type: 'support.php_tag',
        value: '?>'
    }, {
        type: 'paren.lparen',
        value: '{',
        indent: true
    }, {
        type: 'paren.rparen',
        value: '}',
        indent: false
    }, {
        type: 'text',
        value: ';'
    }, {
        type: 'meta.tag.r',
        value: '>'
    }, {
        type: 'meta.tag',
        value: '<',
        blockTag: true,
        indent: true,
        dontBreak: true
    }, {
        type: 'meta.tag',
        value: '</',
        blockTag: true,
        indent: false,
        dontBreak: true
    }, {
        type: 'punctuation.operator',
        value: ';',
        after: true
    }];

    var spaces = [{
        type: 'entity.other.attribute-name',
        prepend: true
    }, {
        type: 'storage.type',
        value: 'var',
        append: true
    }, {
        type: 'keyword.operator',
        value: '='
    }, {
        type: 'keyword',
        value: 'as',
        prepend: true,
        append: true
    }];

    var blockTags = ['html', 'head', 'script', 'style', 'body', 'table', 'tr', 'td', 'div', 'ul', 'li', 'form', 'br'];

    var indentation = 0;
    var dontBreak = false;
    var tag;
    var lastTag;
    var lastToken = {};
    var nextTag;
    var nextToken = {};

    while (token) {
        console.log(token);

        nextToken = iterator.stepForward();

        //tag name
        if (nextToken && nextToken.type.substr(0, 17) == 'meta.tag.tag-name') {
            nextTag = nextToken.value;
        }

        //don't linebreak
        if (
        lastToken.type == 'support.php_tag' && lastToken.value == '<?=') {
            dontBreak = true;
        }

        //lowercase
        if (token.type == 'meta.tag.tag-name') {
            token.value = token.value.toLowerCase();
        }

        //trim spaces
        if (token.type == 'text') {
            token.value = token.value.trim();
        }

        //skip empty tokens
        if (!token.value) {
            token = nextToken;
            continue;
        }

        //put spaces back in
        for (var i in spaces) {
            if (
            token.type == spaces[i].type && (!spaces[i].value || token.value == spaces[i].value)) {
                if (spaces[i].prepend) {
                    token.value = ' ' + token.value;
                }

                if (spaces[i].append) {
                    token.value += ' ';
                }
            }
        }

        //tag name
        if (token.type.substr(0, 17) == 'meta.tag.tag-name') {
            tag = token.value;
        }

        //new line before
        if (!dontBreak) {

            //outdent
            for (i in newLines) {
                if (
                token.type == newLines[i].type && token.value == newLines[i].value && (!newLines[i].blockTag || (
                blockTags.indexOf(nextTag) !== -1))) {
                    if (newLines[i].indent === false) {
                        indentation--;
                    }
                    console.log(token.value);
                    console.log(indentation);

                    break;
                }
            }

            for (i in newLines) {
                if (
                lastToken.type == newLines[i].type && lastToken.value == newLines[i].value && (!newLines[i].blockTag || (
                blockTags.indexOf(tag) !== -1))) {
                    if (newLines[i].indent === true) {
                        indentation++;
                    }

                    console.log(lastToken.value);
                    console.log(indentation);

                    if (!newLines[i].dontBreak) {
                        code += "\n";

                        //indent
                        for (i = 0; i < indentation; i++) {
                            code += "\t";
                        }
                    }

                    break;
                }
            }
        }

        code += token.value;

        //linebreaks back on after end short php tag
        if (
        token.type == 'support.php_tag' && token.value == '?>') {
            dontBreak = false;
        }

        //next token
        lastTag = tag;

        lastToken = token;

        token = nextToken;

        if (!token) {
            break;
        }
    }

    editor.getSession().setValue(code);
}

