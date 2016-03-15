cccomus.controller('UploadController', [
    '$scope',
    '$window',
    '$resource',
    '$timeout',
    'utilities',
    'Reviews',
    function ($scope, $window, $resource, $timeout, utilities, Reviews) {

        utilities.showInfo('Loading... Please Wait');

        // Get the template HTML and remove it from the document
        var previewNode = document.querySelector("#template");
        previewNode.id = "";

        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        //Initialize dropzone.
        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/admin/reviews/processUpload", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        });

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() {

                if(validate(file, file.previewElement.querySelector('#issuer_id').value)) {
                    myDropzone.enqueueFile(file);
                }
            };
        });

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
        });

        myDropzone.on("sending", function(file, xhr, formData) {

            // Show the total progress bar when upload starts
            jQuery('#total-progress').show();

            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
            formData.append('_token', file.previewElement.querySelector('#token').value);
            formData.append('issuer_id', file.previewElement.querySelector('#issuer_id').value);
        });

        // Hide the total progress bar when files are removed from queue, e.g. user clicks cancel.
        myDropzone.on('removedfile', function() {
            jQuery('#total-progress').hide();
        });

        myDropzone.on("success", function(file, xhr) {

            if(xhr.stats.errors == 0) {
                utilities.showSuccess(xhr.stats.successes + ' reviews have been uploaded!');
            }
            else {
                utilities.showError(xhr.stats.successes + ' reviews have been uploaded with '+xhr.stats.errors+' errors');
                jQuery('.progress-bar').hide();
            }

            // Hide progress bar two seconds after all files have been uploaded.
            $timeout(function() {
                jQuery('#total-progress').hide();
            }, 2000);

        });

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            var $queuedFiles = jQuery('.file-row'),
                doContinue = true, // Used to break out of validation check loop
                valid = false; // Used to determine whether to upload files

            angular.forEach($queuedFiles, function(file, key) {

                if (doContinue) { // If validation has failed for a previous file, no need to continue validation checks.
                    var isValid = true;

                    if (!isValid) {
                        doContinue = false;
                        valid = false;
                    } else {
                        valid = true;
                    }
                }

            });

            if (valid) {
                myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
            }
        };
        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true);
        };


        /**
         * Validate any required fields.
         * @returns {boolean}
         */
        var validate = function(file, issuer_id) {
            var valid = true;

            if(issuer_id == '') {
                utilities.showError('Issuer is Required');
                valid = false;
            }



            if(file == '') {
                utilities.showError('CSV file is required');
                valid = false;
            }
            else {

                var fileName = file.name,
                    fileExt = '.' + fileName.split('.').pop();

                if(fileExt != '.csv') {
                    utilities.showError('File must be of type .CSV');
                    valid = false;
                }
            }

            return valid;
        }
    }]);