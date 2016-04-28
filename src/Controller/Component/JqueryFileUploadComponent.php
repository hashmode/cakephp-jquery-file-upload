<?php
namespace CakephpJqueryFileUpload\Controller\Component;

use Cake\Controller\Component;

/**
 * JqueryFileUpload Component
 * 
 */
class JqueryFileUploadComponent extends Component
{

    public function upload($options = null)
    {
        $upload = new \UploadHandler($options);
        return $upload->response;
    }

}