# Cakephp-Jquery-File-Upload

This is a **Cakephp 3.x** vendor/plugin for blueimp jquery file upload widget https://github.com/blueimp/jQuery-File-Upload

## Requirements
1. Cakephp 3.x
2. Blueimp Jquery File Upload  - https://github.com/blueimp/jQuery-File-Upload (dependency is added into the plugin's composer, so it wil be automaticaly installed)

## Installation
**1)** Installation is done by composer: add the following into your main composer.json (inside require) and then run `composer update`

```
"hashmode/cakephp-jquery-file-upload": "~1.0"
```

To use the css and js files from the original library, they are being copied to plugin's webroot directory: for that inside your application's main `composer.json` the following should be added
```
"scripts": {
    "post-update-cmd": "CakephpJqueryFileUpload\\Console\\Installer::postUpdate"
},
```

**2)** Load Plugin from bootstrap, and add component into controller, helper - to AppView
```
// bootstrap.php
Plugin::load('CakephpJqueryFileUpload');

// inside your controller's initialize
$this->loadComponent('CakephpJqueryFileUpload.JqueryFileUpload');

// inside AppView.php initialize
$this->loadHelper('CakephpJqueryFileUpload.JqueryFileUpload');
```

**3)** To add the `UploadHelper` class to autoload classmap, add this into your main composer - under `autoload`, same level as `psr-4`
```
"classmap": [
	"vendor/blueimp/jquery-file-upload/server/php"
]        
```
and run `composer dump-autoload`

**4)** Simple setup example

```
<?php echo $this->JqueryFileUpload->loadCss(); ?>
<?php echo $this->JqueryFileUpload->loadScripts(); ?>

<span class="btn btn-success fileinput-button">
    <i class="glyphicon glyphicon-plus"></i>
    <span>Select files...</span>
    <!-- The file input field used as target for the file upload widget -->
    <input id="fileupload" type="file" name="files[]" multiple>
</span>

<script type="text/javascript">
$(function () {

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: '/myController/myAction'
    });
    
});
</script>
```

inside your `myAction`

```
// example options
$options = array(
    'max_file_size' => 2048000,
    'max_number_of_files' => 10,
    'access_control_allow_methods' => array(
        'POST'
    ),
    'access_control_allow_origin' => Router::fullBaseUrl(),
    'accept_file_types' => '/\.(jpe?g|png)$/i',
    'upload_dir' => WWW_ROOT . 'files' . DS . 'uploads' . DS,
    'upload_url' => '/files/uploads/',
    'print_response' => false
);

$result = $this->JqueryFileUpload->upload($options);
```

For full `$options` please refer to https://github.com/blueimp/jQuery-File-Upload


# License
MIT
