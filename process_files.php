<?php
include("include/session.php");

echo "<a href = 'moving_files.php'>Return to Move Files page</a><hr />";

       if(isset($_POST['subList_folders'])) {
            ListFilesInDir();
        }
        else if(isset($_POST['subList_files'])) {
            ListFilesInMultiDir();
        }
        else if(isset($_POST['subcreate_folders'])) {
            CreateFolders();
        }
        else if(isset($_POST['subfiles_to_multiple'])) {
            MoveToMulti();
        }           
        else if(isset($_POST['subfiles_out_multiple'])) {
            OutOfMulti();
        }
        else if(isset($_POST['subShuffle'])) {
            Shuffle_files();
        }
        else if(isset($_POST['subGetFileContents'])) {
            GetFile();
        }
        else if(isset($_POST['subRename'])) {
            RenameFiles();
        }
		else if(isset($_POST['subRenameMove'])) {
            RenameMoveFiles();
        }
        else {
            header("Location: moving_files.php");
        }
        
//*****************************************	
	function getClassicBook($z) {
		
		$classicBooks = array(
			"101 Dalmations",
			"A Christmas Carol",
			"A Midsummer Night's Dream",
			"A Tale of Two Cities",
			"Adventures of Huckleberry Finn",
			"Anna Karenina",
			"Anne of Green Gables",
			"Benjamin Franklin",
			"Call of the Wild / White Fang",
			"Canterbury Tales",
			"Captain Courageous & Other Stories",
			"Doctor Zhivago",
			"Don Quixote",
			"Dutchman & The Slave",
			"For Whom The Bell Tolls",
			"Four Tragedies and Octavia",
			"Frankenstein",
			"Gone with the Wind",
			"Great Expectations",
			"Great Short Works Of Leo Tolstoy",
			"Greek and Roman Classics",
			"Gulliver's Travels",
			"House if the Seven Gables",
			"Iliad",
			"In The Days of The Comet",
			"Ivanhoe",
			"Journey to the Center of the Earth",
			"Julius Caeser",
			"Jungle Book Vol. 1",
			"King Lear",
			"Les Lraisons Dangereuss",
			"Les Miseables",
			"Letters from the Earth",
			"Moby Dick",
			"Notes From The Underground",
			"Oliver Twist",
			"Phineas Finn",
			"Pilgrim's Progress",
			"Portable Plato",
			"Romeo and Julliet",
			"Steinbeck Of Mice And Man",
			"Swiss Family Robinson",
			"Tales From 1001 Nights",
			"Tender is the Night",
			"The Adventures Of Ulysses",
			"The Awakening",
			"The Balcony",
			"The Beautiful and The Damned",
			"The Count of Monte Cristo",
			"The Death Of Ivan Ilych",
			"The Divine Comedy",
			"The General In His Labrynth",
			"The Great Gatsby",
			"The Heart is a Lonely Hunter",
			"The Hunchback Of Notre Dame #1",
			"The Jungle",
			"The Last Days of Socrates",
			"The Love of the Last Tycoon",
			"The Man In The Iron Mask",
			"The Moonstone",
			"The Naked and The Dead",
			"The Odyssey",
			"The Old Man and The Sea",
			"The Pioneers",
			"The Prince and the Pauper",
			"The Red Pony",
			"The Scarlet Letter",
			"The Sheriff of Nottingham",
			"The Strange Case of Dr. Jekyll and Mr. Hyde",
			"The Thorn Birds",
			"The Travels of Marcao Polo",
			"To Kill A Mockingbird",
			"Tom Jones",
			"Tom Sawer",
			"Treasure Island",
			"Twenty Thousand Leagues Under the Sea",
			"Uncle Tom's Cabin",
			"War And Peace",
			"Wuthering Heights "
		);

		return $classicBooks[$z];
		
/*		$i = 0;
		foreach ($classicBooks as $book) {
			echo "classic book number ".$i." is ".$book."<br />";
			$i++;
		}
*/

	}


//*****************************************	  

    function ListFilesInDir() {
        global $session;
        
        $_POST= $session->cleanInput($_POST);
            // New folder Location
        $dir = $_POST['dir_list'];
        $dir = addslashes($dir);
    
        $i = 0;

        if ($handle = opendir($dir)) {
//            echo "Directory handle: $handle";
//            echo "Entries:";
//        $files1 = scandir($dir, $sorting_order = SCANDIR_SORT_NONE);
//        echo "count: ". count($files1)."<br />";
// This is the correct way to loop over the directory. 

            echo "<br />";

            while (false !== ($entry = readdir($handle))) {
            if(strlen($entry) > 4) {
            $dir_list[$i] = $entry;
//            $file_size[$i] = filesize($entry);
            $i++;
            }
            }        
        }
/*
 $x = 0;       
        while ($x < $i) {
        $path_parts = pathinfo($dir_list[$x]);
        echo "File Name: ".$path_parts['filename']."File Size: ".filesize($file_size[$x])." bytes<br />";
        $x++;
        }
*/
      
        foreach ($dir_list as $file) {
          
        $path_parts = pathinfo($file);
//        echo "File Name: ".$path_parts['filename']."<br />";
          echo $path_parts['filename']."<br />";
        }
     unset($dir_list);
    }
 echo "<hr />";

//*****************************************	    

    function ListFilesInMultiDir() {
        global $session;
        
        $_POST= $session->cleanInput($_POST);
            // New folder Location
        $dir = $_POST['dir_list'];
        $dir = addslashes($dir);
    
        $i = 0;

        if ($handle = opendir($dir)) {
//            echo "Directory handle: $handle";
//            echo "Entries:";
//        $files1 = scandir($dir, $sorting_order = SCANDIR_SORT_NONE);
//        echo "count: ". count($files1)."<br />";
// This is the correct way to loop over the directory. 

            echo "List of folders in folder: ".$dir."<br />";

            while (false !== ($entry = readdir($handle))) { 
            if(is_string($entry) && strlen($entry > "2")) {
//            echo "I = ".$i."<br />";
            $dir_list[$i] = $entry;
            $i++;
 //           echo "entry = ".$entry;
            }
            }  
//            echo "first foreach<br />";
        natsort($dir_list);
        foreach ($dir_list as $file) {
          
        $path_parts = pathinfo($file);
        echo $path_parts['filename']."<br />";
 
        }
//        echo "end of first foreach<br />";
        }
//        echo "the line below is just after end of first foreach<br /><hr />";
 //       foreach ($dir_list as $file) {
          
//        $path_parts = pathinfo($file);
//        echo $path_parts['filename']."<br />";
            
 //       echo "just after pathparts<hr />";
        
        foreach ($dir_list as $file) {
          echo "<hr />";
          echo "Contents of -  ".$file."<br /><br />";
        if ($handle = opendir($dir."/".$file)) {
//            echo "Directory handle: $handle";
//            echo "Entries:";
//        $files2 = scandir($dir."/".$file, $sorting_order = SCANDIR_SORT_NONE);
//        echo "count: ". count($files2)."<br />";
// This is the correct way to loop over the directory. 

$z = 0;
            while (false !== ($entry2 = readdir($handle))) { 
            if($z > 1) {
            $dir_list2[$z] = $entry2;
            $z++;
            }
            else {
                $z++;
            }
            }    
        }
        
        foreach ($dir_list2 as $file3) {
          
        $path_parts2 = pathinfo($file3);
        echo $path_parts2['filename']."<br />";
 
        }
        unset($dir_list2);
        }

        unset($dir_list); 
//    }
    }
   
//*****************************************	            
    function CreateFolders() {
        global $session;

            $_POST= $session->cleanInput($_POST);
            // New folder Location
            $dir = $_POST['new_folder_loc'];
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
		function MoveToMulti() {
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
//				natsort($entry);
                if(strlen($entry) > 4) {
				
					$path_parts = pathinfo($entry);
					if($path_parts['extension'] == "mp3") {
						$filename = $path_parts['filename'];
						rename($entry, $filename."mp4");
					}
				

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

    function OutOfMulti() {
        global $session;

        $_POST= $session->cleanInput($_POST);
        // File Location
        $dir = $_POST['file_loc'];
        $dir = addslashes($dir);
        // destination folder
        $dest_dir = $_POST['dest_dir'];
        $dest_dir = addslashes($dest_dir);

        if ($handle = opendir($dir)) {
         //   echo "Directory handle: $handle";
         //   echo "Entries:";
        $files1 = scandir($dir);
        $count_folders = count($files1);
        echo "Number of folders: ". count($files1)."<br />";


            /* This is the correct way to loop over the directory. */

            echo "<br />";

            while (false !== ($entry = readdir($handle))) {
        }
        }
        var_dump($files1);
        echo "<br /><hr />";
        echo "print_r<br />";
        print_r($files1);
        echo "<hr /><br />";
        for ($i=2; $i < $count_folders; $i++) {

        $new_dir = $dir."/".$files1[$i];
        echo "<br />New dir ".$new_dir."<br />";
        if ($new_handle = opendir($new_dir)) {

            $new_files1 = scandir($new_dir);
        echo "count: ". count($new_files1)."<br />";
            /* This is the correct way to loop over the directory. */

            while (false !== ($new_entry = readdir($new_handle))) {
            if(strlen($new_entry) > 4) {
        //	echo "New entry: ".$new_entry."<br />";
            $file_in_folder = array($new_entry);
        foreach ($file_in_folder as $file) {
            echo "File in folder".$new_dir." - ".$file."<br />";
            rename($new_dir."/".$file, $dest_dir."/".$file);
            }
        }
        }
        }
        }
        unset($file_in_folder);
    }

// **************************************

    function Shuffle_files() {
        global $session;

        $_POST= $session->cleanInput($_POST);
        // File Location
        $dir = $_POST['file_loc'];
        $dir = addslashes($dir);
        // destination folder
        $dest_dir = $_POST['dest_dir'];
        $dest_dir = addslashes($dest_dir);
        // use to make empty folders
        $first_folder = $_POST['first_folder_no'];
        $num_in_folder = $_POST['num_in_folder'];
        
        $shuffle_files = scandir($dir);
        $i = 1;
        $folder = $first_folder;
        shuffle($shuffle_files);

        $structure = $dest_dir."/".$folder."/";
            if (!mkdir($structure, 0777, true)) {
                die('Failed to create folders...');
                                }
        echo "First dir made<hr />";

        foreach ($shuffle_files as $music_file) {
    
		if(strlen($music_file) > 4) {

            echo $music_file."<br />";
			
            if($i == $num_in_folder) {
				echo "<br /><hr /><br />";
				$i = 1;
				$folder = ++$folder;
				$structure = $dest_dir."/".$folder."/";
				if (!mkdir($structure, 0777, true)) {
				die('Failed to create folders...');
						}
				}
	
			$i++;
			rename($dir."/".$music_file, $dest_dir."/".$folder."/".$music_file);
	
		}
	}
    }

// **************************************

    function GetFile() {
        global $session;

        $_POST= $session->cleanInput($_POST);
        // File Location
		$cwd = $_POST['cwd'];
        $cwd = addslashes($cwd);
        $dir = $_POST['get_context1'];
        $dir = addslashes($dir);
        $dir2 = $_POST['get_context2'];
        $dir2 = addslashes($dir2);
		$dir3 = $_POST['get_context3'];
        $dir3 = addslashes($dir3);
		$dir4 = $_POST['get_context4'];
        $dir4 = addslashes($dir4);
		$dir5 = $_POST['get_context5'];
        $dir5 = addslashes($dir5);
		$dir6 = $_POST['get_context6'];
        $dir6 = addslashes($dir6);
        
   $files = fopen($cwd."/".$dir, "r+");

// echo $files."<br />";

// Get a file into an array.  In this example we'll go through HTTP to get
// the HTML source of a URL.
$lines = file($cwd."/".$dir);

// Loop through our array, show HTML source as HTML source; and line numbers too.
foreach ($lines as $line_num => $line) {
    echo /*"Line #<b>{$line_num}</b> :<br />" . */htmlspecialchars($line) . "<br />\n";
}
        
        
/* 
echo "<hr />";
foreach ($lines as $line_num => $line) {
    echo  htmlspecialchars($line);
}
echo "<hr /><br />Directory 2<br /><hr />";     
// From here down is Directory 2
$files = fopen($dir2, "r+");
// echo $files."<br />echoed files<br />";
// Get a file into an array.  In this example we'll go through HTTP to get
// the HTML source of a URL.
$lines = file($dir2);
foreach ($lines as $line_num => $line) {
    echo  htmlspecialchars($line);
}
*/
      
echo "<hr /><br />file_get_contents below<br /><hr />";

        
$page2 = file_get_contents($cwd."/".$dir2);
echo $page2."<hr />";

if ($dir3) {
$page3 = file_get_contents($cwd."/".$dir3);
echo $page3."<hr />";
}
if($dir4) {
$page4 = file_get_contents($cwd."/".$dir4);
echo $page4."<hr />";
}
if($dir5) {
$page5 = file_get_contents($cwd."/".$dir5);
echo $page5."<hr />";
}
if($dir6) {
$page6 = file_get_contents($cwd."/".$dir6);
echo $page6."<hr />";
}  
 /*     
$path_parts2 = pathinfo($dir2);

$new_file_loc =  $path_parts2['dirname'];   

$arr = str_split($homepage, 8300);
$num = 0;
        
foreach ($arr as $newtext) {
$newtext = wordwrap($newtext, 8300, "<br />", false);
echo "<hr />".$newtext."<hr />";
// Write the contents back to the file
file_put_contents($new_file_loc."/new_file".$num.".txt", $newtext);
$num++;
}
    unset($newtext);          
 */       
    }

// **************************************

  function RenameFiles() {
        global $session;
        
        $_POST= $session->cleanInput($_POST);
            // New folder Location
        $rename_path = $_POST['rename_path'];
        $rename_path = addslashes($rename_path);
        $newExtension = $_POST['newExtension'];
    
        $i = 0;

        if ($handle = opendir($rename_path)) {
         echo "<br />";

            while (false !== ($entry = readdir($handle))) {
//            if(strlen($entry) > 4) {
            $dir_list[$i] = $entry;
//            $file_size[$i] = filesize($entry);
            $i++;
//            }
            }        
        }

      
        foreach ($dir_list as $file) {
          
            $path_parts = pathinfo($file);
            echo "File = ".$file."<br />";
    //        echo "File Name: ".$path_parts['filename']."<br />";
              echo "Filename: ".$path_parts['filename']."<br />";
              echo "Extension: ".$path_parts['extension']."<br />";
             $cur_file_name = $path_parts['filename'];
             $cur_ext = $path_parts['extension'];
            if($cur_ext == "noob"){
                rename($file, $cur_file_name.".".$newExtension);
            }
            echo "<hr />";
        }
     unset($dir_list);
    }
 echo "<hr />";

// **************************************

  function RenameMoveFiles() {
        global $session;

        echo "Rename and Move files <hr />";
        $_POST= $session->cleanInput($_POST);
            // New folder Location
        $file_loc = $_POST['file_loc'];
		$useThis = $_POST['useThis'];
//		echo "file loc ".$file_loc."<hr />";
	
//		$file_loc = addslashes($file_loc);
        $dest_dir = $_POST['dest_dir'];
//		$dest_dir = addslashes($dest_dir);
//		echo"dest dir ".$dest_dir."<hr />";

		$baseName = $_POST['baseName'];
//		$dest_dir = addslashes($rename_path);

    
        $i = 0;

        if ($handle = opendir($file_loc)) {
         echo "<br />";

            while (false !== ($entry = readdir($handle))) {
			/* **** THIS strlen($entry) > 4  MUST BE PRESENT TO EXCLUDE THE . AND .. HIDDEN FOLDERS   ****  */
            if(strlen($entry) > 4) {
            $dir_list[$i] = $entry;
//			echo "dir list $i ".$dir_list[$i]."<hr />"; 
			
			
//            $file_size[$i] = filesize($entry);
            $i++;
            }
            }        
        }
	 $today = date('Y-m-d');
     $z=0;
        foreach ($dir_list as $file) {
          
            $path_parts = pathinfo($file);
//            echo "File = ".$file."<br />";
//            echo "File Name: ".$path_parts['filename']."<br />";
//           echo "Filename: ".$path_parts['filename']."<br />";
//            echo "Extension: ".$path_parts['extension']."<br />";
           $cur_file_name = $path_parts['filename'];
			$cur_ext = $path_parts['extension'];
			
			if($useThis == 1) {
				$newFileName = $baseName." ".$today." ".$z.".".$cur_ext;
			}
			else {
			$classicBookName = getClassicBook($z);
			$newFileName = $classicBookName."_".$today.".".$cur_ext;
			}
//			echo "book number ".$z." is ".$classicBookName."<br />";
			
//          echo "newFileName = ".$newFileName."<br />";
//            rename($file, $newFileName);

// RENAMED DIRECTORY AS TODAY # CUR EXT INSTEAD OF FILE
			rename($file_loc."/".$file, $dest_dir."/".$newFileName);
			
		$z++;
            echo "<hr />";
        }
     unset($dir_list);
    }
 echo "<hr />";
			
			
			
			
			
			
			
			
			
			
			