<?php
include("include/session.php");


class Process_files
	{
		/* Class Constructor */
    function Process() {
        global $session;

        if(isset($_POST['subcreate_folders'])) {
            $this->procCreateFolders();
        }
        else if(isset($_POST['subfiles_to_multiple'])) {
            $this->procMoveToMulti();
        }
 /*           
        else if(isset($_POST['subjoin'])) {
            $this->procRegister();
        }
        else if(isset($_POST['subedit'])) {
            $this->procEditAccount();
        }
        else if($session->logged_in) {
            $this->procLogout();
        }
*/
        else {
            header("Location: moving_files.php");
        }
        header("Location: moving_files.php");
    }
//*****************************************	            
    function procCreate_Folders() {
        global $session;

            $_POST= $session->cleanInput($_POST);
            // New folder Location
            $dir = $_POST['new_file_loc'];
            $dir = addslashes($dir);
        // use to make empty folders
        $first_folder = $_POST['first_folder_no'];
        $num_folders = $_POST['num_folders'];
        $last_folder_no = $first_folder + $num_folders;
        
        for ($i = $first_folder; $i <= $last_folder_no; $i++) {
        $structure = $dir."/empty folders/".$i."/";
        if (!mkdir($structure, 0777, true)) {
            die('Failed to create folders...');
        }
        }
    }
//*****************************************	
		function procMoveToMulti() {
			global $session;

            $_POST= $session->cleanInput($_POST);
            // File Location
            $dir = $_POST['file_loc'];
            $dir = addslashes($dir);
            // destination folder
            $dest_dir = $_POST['dest_dir'];
            $dest_dir = addslashes($dest_dir);
            // beginning folder number
            $folder = $_POST['first_folder_no'];
            // Enter file position
            $position = 1;

            if ($handle = opendir($dir)) {
                echo "Directory handle: $handle";
                echo "Entries:";
            $files1 = scandir($dir);
            echo "count: ". count($files1)."<br />";
                /* This is the correct way to loop over the directory. */

                echo "[<br />";

                while (false !== ($entry = readdir($handle))) {
                if(strlen($entry) > 4) {
                $movies_moved = array($entry);
                $structure = $dest_dir."/".$folder."/";
            if (!mkdir($structure, 0777, true)) {
                die('Failed to create folders...');
            }
                rename($dir."/".$entry, $dest_dir."/".$folder."/".$entry);

                echo "{<br />";
                echo "\"content_id\": ".$folder.",<br />";
                echo "\"html_url\": \"https://lms.projectlantern.com/courses/121/modules/items/7410\",<br />";
                echo "\"id\": 7410,<br />";
                echo "\"indent\": 1,<br />";
                echo "\"module_id\": 1034,<br />";
                echo "\"position\": ".$position.",<br />";
                echo "\"published\": true,<br />";
                echo "\"title\": \"".$entry."\",<br />";
                echo "\"type\": \"File\",<br />";
                echo "\"url\": \"https://lms.projectlantern.com/api/v1/files/".$folder."\"<br />";
                echo "},<br />";
                $folder++;
                $position++;
                }

                }
            echo "]";
            }

            echo "<hr />";
            foreach ($movies_moved as $mov) {
                echo $mov."<br />";
                }

            unset($mov);
		}
// **************************************
/*
		function procLogout() {
			global $session;
			$retval = $session->logout();
			header("Location: index.php");
		}
	
		function procRegister() {
			global $session, $form;
			$_POST= $session->cleanInput($_POST);
			if(ALL_LOWERCASE) {
				$_POST['gdc_no'] = strtolower($_POST['gdc_no']);
			}
		
			$retval = $session->register($_POST['fname'], $_POST['lname'], $_POST['gdc_no'], $_POST['pass']);

			if($retval == 0) {
				$_SESSION['reguname'] = $_POST['gdc_no'];
				$_SESSION['regsuccess'] = true;
				header("Location: ".$session->referrer);
			}
			else if($retval == 1) {
				$_SESSION['value_array'] = $_POST;
				$_SESSION['error_array'] = $form->getErrorArray();
				header("Location: ".$session->referrer);
			}
			else if($retval == 2) {
				$_SESSION['reguname'] = $_POST['gdc_no'];
				$_SESSION['regsuccess'] = false;
				header("Location: ".$session->referrer);
			}
		}
	
		function procEditAccount() {
			global $session, $form;
			$_POST = $session->cleanInput($_POST);
			$retval = $session->editAccount($_POST['curpass'], $_POST['newpass'], $_POST['lname']);
		
			if($retval) {
				$_SESSION['useredit'] = true;
				header("Location: ".$session->referrer);
			}
			else {
				$_SESSION['value_array'] = $_POST;
				$_SESSION['error_array'] = $form->getErrorArray();
				header("Location: ".$session->referrer);
			}
		}
*/
	};
// Is the problem with making a variable with the same name as a function see line 8			
	$process = new Process_files;

?>		
			
			
			
			
			
			
			
			
			
			
			