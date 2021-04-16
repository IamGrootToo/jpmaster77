<?php
?>

<html>
<head>
<title>Move Files</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
<div class="container_12">
    
<div class="form_container_left">
  <form name="login" class="login" action="process_files.php" method="POST">
    <fieldset>
    <legend>List of files in a directory</legend>
    <label>Choose directory<input type="text" name="dir_list" /></label><br />
    <input type="hidden" name="subList_folders" value="1" />
    <input type="submit" value="List Files" />
    </fieldset>
  </form>  

    </div>

     <div class="form_container_right">
  <form name="login" class="login" action="process_files.php" method="POST">
    <fieldset>
    <legend>List of files in multiple folders in a directory</legend>
    <label>Choose directory<input type="text" name="dir_list" /></label><br />
    <input type="hidden" name="subList_files" value="1" />
    <input type="submit" value="List Files" />
    </fieldset>
  </form>  

    </div>


    
<div class="form_container_left">
<form name="login" class="login" action="process_files.php" method="POST">
    <fieldset>
    <legend>Move files to multiple folders</legend>
    <label>Choose directory where files are located<input type="text" name="file_loc" /></label><br />
    <label>Choose destination directory<input type="text" name="dest_dir" /></label><br />
    <label>Enter first folder number<input type="text" name="first_folder_no"  /></label><br />
    <input type="hidden" name="subfiles_to_multiple" value="1" />
    <input type="submit" value="Move files" />
    </fieldset>
		</form>
</div>
 
 
<div class="form_container_right">
<form name="login" class="login" action="process_files.php" method="POST">
    <fieldset>
    <legend>Move files out of multiple folders</legend>
    <label>Choose directory where files are located<input type="text" name="file_loc" /></label><br />
    <label>Choose destination directory<input type="text" name="dest_dir" /></label><br />
    <input type="hidden" name="subfiles_out_multiple" value="1" />
    <input type="submit" value="Move files" />
    </fieldset>
		</form>
</div>
    

    
<div class="form_container_left">
  <form name="login" class="login" action="process_files.php" method="POST">
      <fieldset>
    <legend>Create empty folders</legend>
    <label>Choose directory for new folders<input type="text" name="new_folder_loc" /></label><br />
    <label>Enter first folder number<input type="text" name="first_folder_no"  /></label><br />
    <label>Enter number of folders to create<input type="text" name="num_folders"  /></label><br />
    <input type="hidden" name="subcreate_folders" value="1" />
    <input type="submit" value="Create Folders" />
      </fieldset>
		</form>  
    </div>
    

    
<div class="form_container_right">
<form name="login" class="login" action="process_files.php" method="POST">
    <fieldset>
    <legend>Shuffle files and put in folders of entered quantity</legend>
    <label>Choose directory where files are located<input type="text" name="file_loc" /></label><br />
    <label>Choose destination directory<input type="text" name="dest_dir" /></label><br />
    <label>Enter first folder number<input type="text" name="first_folder_no"  /></label><br />
    <label>Enter number of files to put in each folder<input type="text" name="num_in_folder"  /></label><br />
    <input type="hidden" name="subShuffle" value="1" />
    <input type="submit" value="Move files" />
    </fieldset>
		</form>
</div>
    
<div class="form_container_left">
  <form name="login" class="login" action="process_files.php" method="POST">
      <fieldset>
    <legend>Get contents of file</legend>
	<label>Enter path to file and file name<input type="text" name="cwd" /></label><br />
    <label>Enter path to file and file name<input type="file" name="get_context1" /></label><br />
    <label>Enter path to file and file name<input type="file" name="get_context2" /></label><br />
	<label>Enter path to file and file name<input type="file" name="get_context3" /></label><br />
	<label>Enter path to file and file name<input type="file" name="get_context4" /></label><br />
	<label>Enter path to file and file name<input type="file" name="get_context5" /></label><br />
	<label>Enter path to file and file name<input type="file" name="get_context6" /></label><br />
    <input type="hidden" name="subGetFileContents" value="1" />
    <input type="submit" value="Get File Contents" />
      </fieldset>
		</form>  
    </div>
    
<div class="form_container_right">
  <form name="login" class="login" action="process_files.php" method="POST">
      <fieldset>
    <legend>Rename file extension</legend>
    <label>Enter path to files<input type="text" name="rename_path" /></label><br />
    <label>Enter new extension<input type="text" name="newExtension" /></label><br />
    <input type="hidden" name="subRename" value="1" />
    <input type="submit" value="Rename Files" />
      </fieldset>
		</form>  
    </div>
	
<div class="form_container_right">
<form name="login" class="login" action="process_files.php" method="POST">
    <fieldset>
    <legend>Rename files and move to another folder</legend>
    <label>Choose directory where files are located</label><input type="text" name="file_loc" /><br />
	<label>Choose destination directory<input type="text" name="dest_dir" /></label><br />
	<label>Click this box to use name entered here&nbsp;&nbsp;&nbsp;<input type="checkbox" name="useThis" value="1" /></label><br />
	<label>Enter base name for new files (a number will be added to the end)<input type="text" name="baseName" /></label><br />
	
    <input type="hidden" name="subRenameMove" value="1" />
    <input type="submit" value="Rename and Move files" />
    </fieldset>
		</form>
</div>
    
    
    </div>
    </body>
</html>