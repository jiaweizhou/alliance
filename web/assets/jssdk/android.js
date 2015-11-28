var domain="http://7xkbeq.com1.z0.glb.clouddn.com";
    var uploader = Qiniu.uploader({
        runtimes: 'html5,flash,html4',
        browse_button: 'android',
        container: 'container',
        drop_element: 'container',
        max_file_size: '100mb',
        flash_swf_url: '/assets/jssdk/Moxie.swf',
        dragdrop: true,
        chunk_size: '4mb',
        uptoken_url: '/admin/token',
        unique_names: true,
        save_key: true,
        domain: domain,
        auto_start: true,
        init: {
            'FilesAdded': function(up, files) {
                $('table').show();
                $('#success').hide();
                plupload.each(files, function(file) {
                    var progress = new FileProgress(file, 'fsUploadProgress');
                    progress.setStatus("等待...");
                });
            },
            'BeforeUpload': function(up, file) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                if (up.runtime === 'html5' && chunk_size) {
                    progress.setChunkProgess(chunk_size);
                }
            },
            'UploadProgress': function(up, file) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));

                progress.setProgress(file.percent + "%", file.speed, chunk_size);
            },
            'UploadComplete': function() {
                $('#success').show();
            },
            'FileUploaded': function(up, file, info) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                progress.setComplete(up, info);
                var obj=JSON.parse(info);

                var form=document.forms['form'];

                var　tempInput　=　document.createElement("input");　  
               　tempInput.type="hidden";　  
               　tempInput.name="android_url";　　  
               　tempInput.value=domain+"/"+obj.key;
                form.appendChild(tempInput);
                
            },
            'Error': function(up, err, errTip) {
                    $('table').show();
                    var progress = new FileProgress(err.file, 'fsUploadProgress');
                    progress.setError();
                    progress.setStatus(errTip);
                },
             'Key': function(up, file) {
                     var key = "";
                     // do something with key
                     return key;
               }
        }
    });

    uploader.bind('FileUploaded', function() {
        console.log('hello man,a file is uploaded');
    });