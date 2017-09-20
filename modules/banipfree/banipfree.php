<?php 
class banipfree extends Module {
	function __construct(){
		$this->name = 'banipfree';
		$this->tab = 'administration';
        $this->author = 'MyPresta.eu';
		$this->version = '1.3.1';
		$this->module_key = '17e90e1a88d93cc58a4263fa9000dd6a';
        $this->dir = '/modules/banipfree/';
		parent::__construct();
		$this->displayName = $this->l('Ban IP free');
		$this->description = $this->l('Ban unwanted users, block any IP you want.Secure your shop');
        $this->mkey="freelicense";       
        if (@file_exists('../modules/'.$this->name.'/key.php'))
            @require_once ('../modules/'.$this->name.'/key.php');
        else if (@file_exists(dirname(__FILE__) . $this->name.'/key.php'))
            @require_once (dirname(__FILE__) . $this->name.'/key.php');
        else if (@file_exists('modules/'.$this->name.'/key.php'))
            @require_once ('modules/'.$this->name.'/key.php');                        
        $this->checkforupdates();
	}

    function checkforupdates(){
            if (isset($_GET['controller']) OR isset($_GET['tab'])){
                if (Configuration::get('update_'.$this->name) < (date("U")>86400)){
                    $actual_version = banipfreeUpdate::verify($this->name,$this->mkey,$this->version);
                }
                if (banipfreeUpdate::version($this->version)<banipfreeUpdate::version(Configuration::get('updatev_'.$this->name))){
                    $this->warning=$this->l('New version available, check www.MyPresta.eu for more informations');
                }
            }
    }
        
	function install(){
        if (parent::install() == false 
	    OR $this->registerHook('home') == false
        OR $this->registerHook('header') == false
        OR !Configuration::updateValue('update_'.$this->name,'0')
        OR Configuration::updateValue('banipfree_1', '') == false
        OR Configuration::updateValue('banipfree_msg', 'You are blocked') == false
        
        ){
            return false;
        }
        return true;
	}
    
	public function getContent(){
	   	$output="";
		if (Tools::isSubmit('module_settings')){            		
			Configuration::updateValue('banipfree_1', $_POST['banipfree_1']);
            Configuration::updateValue('banipfree_2', $_POST['banipfree_2']);
            Configuration::updateValue('banipfree_3', $_POST['banipfree_3']);
            Configuration::updateValue('banipfree_msg', $_POST['banipfree_msg']);
            $output .= '<div class="conf confirm"><img src="../img/admin/ok.gif" alt="'.$this->l('Confirmation').'" />'.$this->l('Settings updated').'</div>';                                   
        }	   
        $output.="";
        return $output.$this->displayForm();
	}

	public function displayForm(){
		$form='';
		return $form.'		
		<div style="diplay:block; clear:both; margin-bottom:20px;" class="bootstrap">
		<iframe src="http://apps.facepages.eu/somestuff/whatsgoingon.html" width="100%" height="150" border="0" style="border:none;"></iframe>
		</div>
		<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
            <fieldset style="position:relative; margin-bottom:10px;">
            <legend>'.$this->l('Ban IP address').'</legend>
            <div style="display:block; margin:auto; overflow:hidden; width:100%; vertical-align:top;">
                <label>'.$this->l('IP Address 1').':</label>
                    <div class="margin-form" style="text-align:left;" >
                    <input type="text" name="banipfree_1" value="'.Configuration::get('banipfree_1').'"/>
                </div>
                <label>'.$this->l('IP Address 2').':</label>
                    <div class="margin-form" style="text-align:left;" >
                    <input type="text" name="banipfree_2" value="'.Configuration::get('banipfree_2').'"/>
                </div>
                <label>'.$this->l('IP Address 3').':</label>
                    <div class="margin-form" style="text-align:left;" >
                    <input type="text" name="banipfree_3" value="'.Configuration::get('banipfree_3').'"/>
                </div>                
                <label>'.$this->l('Want to block more IP numbers?').':</label>
                <div class="margin-form" style="text-align:left;" >
                    <a href="http://mypresta.eu/modules/administration-tools/block-ip-address-pro.html" target="_blank">'.$this->l('Get PRO version').'</a>
                </div>
                <label>'.$this->l('Want statistics?').':</label>
                <div class="margin-form" style="text-align:left;" >
                    <a href="http://mypresta.eu/modules/administration-tools/block-ip-address-pro.html" target="_blank">'.$this->l('Get PRO version').'</a>
                </div>
                <label>'.$this->l('Want redirect blocked users?').':</label>
                <div class="margin-form" style="text-align:left;" >
                    <a href="http://mypresta.eu/modules/administration-tools/block-ip-address-pro.html" target="_blank">'.$this->l('Get PRO version').'</a>
                </div>
                <label>'.$this->l('Message').':</label>
                <div class="margin-form" style="text-align:left;" >
                    <textarea name="banipfree_msg" style="width:200px; height:100px;"/>'.Configuration::get('banipfree_msg').'</textarea>
                </div>                            
                <div style="margin-top:20px; clear:both; overflow:hidden; display:block; text-align:center">
	               <input type="submit" name="module_settings" class="button" value="'.$this->l('save').'">
	            </div>
            </div>
            </fieldset>
		</form>
        
        
        <fieldset style="position:relative; margin-bottom:10px;">
            <legend>'.$this->l('MyPresta').'</legend>
            <div style="display:block; margin:auto; overflow:hidden; width:100%; vertical-align:top;">
                <div style="float:left; text-align:left; display:inline-block; margin-top:5px;">'.$this->l('like us on Facebook').'</br><iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Ffacebook.com%2Fmypresta&amp;send=false&amp;layout=button_count&amp;width=120&amp;show_faces=true&amp;font=verdana&amp;colorscheme=light&amp;action=like&amp;height=21&amp;appId=276212249177933" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px; margin-top:10px;" allowtransparency="true"></iframe>
                </div>
                <div style="float:right; text-align:left; display:inline-block; margin-top:5px;">
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" value="DVWQWWBBRMFSJ">
                        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                        <img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1">
                    </form>
                </div>
            </div>
            </fieldset>
        
        ';
	}   
   
	function hookhome($params){
		$deny = array(Configuration::get('banipfree_1'));
        if (in_array ($_SERVER['REMOTE_ADDR'], $deny)) {
            echo Configuration::get('banipfree_msg');
            die();
        }
	}
    
    function hookheader($params){
		$deny = array(Configuration::get('banipfree_1'));
        $deny2 = array(Configuration::get('banipfree_2'));
        $deny3 = array(Configuration::get('banipfree_3'));
        if (in_array ($_SERVER['REMOTE_ADDR'], $deny)) {
            echo Configuration::get('banipfree_msg');
            die();
        }
        if (in_array ($_SERVER['REMOTE_ADDR'], $deny2)) {
            echo Configuration::get('banipfree_msg');
            die();
        }
        if (in_array ($_SERVER['REMOTE_ADDR'], $deny3)) {
            echo Configuration::get('banipfree_msg');
            die();
        }                
	}
}


class banipfreeUpdate extends banipfree {  
    public static function version($version){
        $version=(int)str_replace(".","",$version);
        if (strlen($version)==3){$version=(int)$version."0";}
        if (strlen($version)==2){$version=(int)$version."00";}
        if (strlen($version)==1){$version=(int)$version."000";}
        if (strlen($version)==0){$version=(int)$version."0000";}
        return (int)$version;
    }
    
    public static function encrypt($string){
        return base64_encode($string);
    }
    
    public static function verify($module,$key,$version){
        if (ini_get("allow_url_fopen")) {
             if (function_exists("file_get_contents")){
                $actual_version = @file_get_contents('http://dev.mypresta.eu/update/get.php?module='.$module."&version=".self::encrypt($version)."&lic=$key&u=".self::encrypt(_PS_BASE_URL_.__PS_BASE_URI__));
             }
        }
        Configuration::updateValue("update_".$module,date("U"));
        Configuration::updateValue("updatev_".$module,$actual_version); 
        return $actual_version;
    }
}
?>