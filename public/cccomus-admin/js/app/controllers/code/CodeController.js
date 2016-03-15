cccomus.controller('CodeController', [
    '$scope',
    '$window',
    '$resource',
    '$location',
    'utilities',
    'Code',
    function ($scope, $window, $resource, $location, utilities, Code) {

        utilities.showInfo("Loading... Please Wait!");

        var wysiwyg = true,
            editor = undefined,
            page_id = utilities.getIdFromUrl();

        /**
         * Calls the server and saves the code.
         */
        $scope.save = function () {

            Code.update({id: page_id}, {content: editor.getValue()},
                function (data) {
                    if (data.message) {
                        utilities.showSuccess("Code has been saved!");
                    }
                    else {
                        utilities.showError("Error occurred during code save");
                    }
                });
        };

        /**
         * Toggle the code editor.
         */
        $scope.codeEditor = function() {

            if(editor !== undefined) {
                //editor.destroy();
            }

            editor = CodeMirror.fromTextArea(content_editor, {
                lineNumbers: true,
                mode: "php",
                theme: "blackboard",
                viewportMargin: 10
            });

            wysiwyg = false;
        };

        /**
         * Toggle CKEditor.
         */
        $scope.wysiwyg = function() {

            if(editor !== undefined) {
                editor.destroy();
            }

            editor = CKEDITOR.replace( 'content_editor', {
                allowedContent: true,
                enterMode : CKEDITOR.ENTER_BR

            } );

            editor.config.protectedSource.push( /<\?[\s\S]*?\?>/g );

            wysiwyg = true;
        };

        $scope.codeEditor();

        Code.get({id : page_id}, function(data) {

            if(wysiwyg) {
                $scope.content_editor = editor.setData(data.contents);
            }
            else {
                $scope.content_editor = editor.setValue(data.contents);
            }

        });

    }]);