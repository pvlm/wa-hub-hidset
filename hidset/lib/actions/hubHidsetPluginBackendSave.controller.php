<?php

class hubHidsetPluginBackendSaveController extends waJsonController
{

    public function execute()
    {
        $plugin = wa()->getPlugin('hidset');
        $hsets = $plugin->hsets;
        $allsets = wa('hub')->getConfig()->getOption(null);
        $error = $check_error = false;
        $data = waRequest::post();
        foreach ($data as $key => $value) {
            if ($hsets[$key]['type'] == 'int') {
                if (strpos($value, ',') || intval($value) != $value  || $value < 1) {
                    $error .=  $key . ' ';
                    $check_error = true;
                }else{
                    $allsets[$key] = intval($value);                    
                }
            }else{
                $allsets[$key] = $value;
            }
            
        }
        
        if (! $check_error) {
            $config = $this->getConfig();
            $config_file = $config->getConfigPath('config.php');
            waUtils::varExportToFile($allsets, $config_file);
        }else{
            $this->setError($error);
        }
        
        $this->response;
    }
}