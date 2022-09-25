/* ------------------------------------------------------------------------------
 *
 *  # Custom JS code
 *
 *  Place here all your custom js. Make sure it's loaded after app.js
 *
 * ---------------------------------------------------------------------------- */

/* ------------------------------------------------------------------------------
 *
 *  # Login form with validation
 *
 *  Demo JS code for login_validation.html page
 *
 * ---------------------------------------------------------------------------- */

// Setup module
// ------------------------------


var DropzoneUpload = (function () {
    var _componentDropzone = function () {
        if (typeof Dropzone == 'undefined') {
            console.warn('Warning - dropzone.min.js is not loaded.');
            return;
        }

        // Multiple files
        Dropzone.options.dropzoneMultipleFiles = {
            paramName: "media", // The name that will be used to transfer the file
            dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
            maxFilesize: 400000000, // MB
            addRemoveLinks: true,
            chunking: true,
            timeout: 120000,
            chunkSize: 1000000,
            // If true, the individual chunks of a file are being uploaded simultaneously.
            parallelChunkUploads: true,
            acceptedFiles: 'video/*',
            init: function () {
                this.on('addedfile', function () {
                    // list.append('<li>Uploading</li>')
                }),
                    this.on('sending', function (file, xhr, formData) {
                        formData.append("_token", csrf_token);

                        // This will track all request so we can get the correct request that returns final response:
                        // We will change the load callback but we need to ensure that we will call original
                        // load callback from dropzone
                        var dropzoneOnLoad = xhr.onload;
                        xhr.onload = function (e) {
                            dropzoneOnLoad(e)

                            // Check for final chunk and get the response
                            var uploadResponse = JSON.parse(xhr.responseText)
                            if (typeof uploadResponse.name === 'string') {
                                // list.append('<li>Uploaded: ' + uploadResponse.path + uploadResponse.name + '</li>')
                            }
                        }
                        xhr.ontimeout = (() => {
                            /*Execute on case of timeout only*/
                            alert('Server Timeout')
                        });
                    })
            }
        };
    };

    return {
        init: function () {
            _componentDropzone();
        }
    }
})();


// Initialize module
// ------------------------------

document.addEventListener("DOMContentLoaded", function () {
});
DropzoneUpload.init();
