<?php

session_start();

require_once('config.php');
require_once('SPSQLite.class.php');


if($_SESSION['phpSQLiteAdmin_currentdb'] == '') {
	$_SESSION['phpSQLiteAdmin_currentdb'] = 'db/phpsla.sqlite';
} elseif(isset($_POST['sessionname'])) {
	$_SESSION['phpSQLiteAdmin_currentdb'] = $_POST['sessionvalue'];
}

// Embedded Images
/*
Embed images using this function:
function encode_img($img)
{
	$fd = fopen ($img, 'rb');
	$size=filesize ($img);
	$cont = fread ($fd, $size);
	fclose ($fd);
	$encimg = base64_encode($cont);
	return $encimg;
}
*/
if (isset($_GET['imgid'])) {
	switch ($_GET['imgid']) {
		case "database.png":
			$imgcode = "iVBORw0KGgoAAAANSUhEUgAAAAsAAAALCAIAAAAmzuBxAAAABGdBTUEAALGPC/xhBQAAAFVJREFUKFNj/P//PwN+AFQBBCcO9iyb64+MgCIQKQa49LVz2f//J0MQkA1UDVEEUgHkIEsjKyJaxcGdtWjGQGwBiqOYgeZSiCKoCmqYAQkMfL7FH2IAUp7xCV2zSGMAAAAASUVORK5CYII=";
			break;
		case "edit.png":
			$imgcode = "iVBORw0KGgoAAAANSUhEUgAAAAsAAAALCAIAAAAmzuBxAAAABGdBTUEAALGPC/xhBQAAAGxJREFUKFN1kMENwCAIRdnVY5dwFBbosWv0wKHr0K9YikSJiSbvRT6QbqoSGRlX0homMmlhVFQ3TMoGqGp57gMMR0Qmw/F1FryBJ2OJ/xw7PIyOFb3j5z5dy2EGM3vvOPww2oRftLSb9cai9ALjByf/vas8pQAAAABJRU5ErkJggg==";
			break;
		case "delete.png":
			$imgcode = "iVBORw0KGgoAAAANSUhEUgAAAAsAAAALCAIAAAAmzuBxAAAABGdBTUEAALGPC/xhBQAAAFhJREFUKFOVUEEOwDAIcu/0x/5gr7E12hVM02SeFAiij7vLvabiFXHV2VCpBm4mgeaAog8pRRMBHRm28yLKzywpUKDTon954O5DDobourylRavs9I/+LJoHDOj+ebMh9FoAAAAASUVORK5CYII=";
			break;
		case "export.png":
			$imgcode = "iVBORw0KGgoAAAANSUhEUgAAAAsAAAALCAIAAAAmzuBxAAAABGdBTUEAALGPC/xhBQAAAElJREFUKFNj+I8KGhoa0EQYkPlAaQhAFkSogEujKUIxA818CJcBTSsmF6TiAG4AlCXODKzWQwShZgBZEHuAjKVIAEUFLmOIcgcANi4S5K6eGuUAAAAASUVORK5CYII=";
			break;
		case "query.png":
			$imgcode = "iVBORw0KGgoAAAANSUhEUgAAAAsAAAALCAIAAAAmzuBxAAAABGdBTUEAALGPC/xhBQAAAFBJREFUKFNj/P//PwN+AFRx4MCBBmwAKA7SD8RAWSCJCSDiIBVwM9YjAaA0wgyIbjST4FyQGUSpwGUA1B14rED4BdmNQDbc76T7Fi3YIL4FANr9DcnCLQhKAAAAAElFTkSuQmCC";
			break;
		case "row_insert.png";
			$imgcode = "iVBORw0KGgoAAAANSUhEUgAAAAsAAAALCAIAAAAmzuBxAAAABGdBTUEAALGPC/xhBQAAAEVJREFUKFNj/P//PwMGaGxsdHBwgAoDVWCChoaGAzDAQJQKoA64OiAbDYDMgAhBFAEZz1ABQgVEET4VBMwg4A5q+Ba/GQA8fBNm+WP9jwAAAABJRU5ErkJggg==";
			break;
		case "table_browse.png";
			$imgcode = "iVBORw0KGgoAAAANSUhEUgAAAAsAAAALCAIAAAAmzuBxAAAABGdBTUEAALGPC/xhBQAAADBJREFUKFNjbGhoYMAPgCoO4AYg/UCMH4BU/McNoGYAFSyFATQ2QgUuUwaZGfjDAwABxvgJEsmisgAAAABJRU5ErkJggg==";
			break;
		case "table_drop.png";
			$imgcode = "iVBORw0KGgoAAAANSUhEUgAAAAsAAAALCAIAAAAmzuBxAAAABGdBTUEAALGPC/xhBQAAAE5JREFUKFNjbGhoYMAPgCoO4AYg/UCMH4BU/McNoGaAFDAw/EdWCmQDRf4DxcC2gFRAhCDq4AwUFRCLINJIhpFkBqY7wCYhmYHDO0SFBwAgBuY3U4A6ewAAAABJRU5ErkJggg==";
			break;
		case "table_empty.png";
			$imgcode = "iVBORw0KGgoAAAANSUhEUgAAAAsAAAALCAIAAAAmzuBxAAAABGdBTUEAALGPC/xhBQAAAE5JREFUKFNjbGhoYMAPgCr+4wYg/XAV169fB7IhAMiG6EJRgaYUoghFBdwquEk4zYBIoNuCrA/Z3QhbIM5EdiAWlxL2C9ZAgdoCdwRWBgCNfACU8GKOGgAAAABJRU5ErkJggg==";
			break;
		case "table_structure.png";
			$imgcode = "iVBORw0KGgoAAAANSUhEUgAAAAsAAAALCAIAAAAmzuBxAAAABGdBTUEAALGPC/xhBQAAACtJREFUKFNjbGhoYMAPgCr+4wYg/RAVB8AAyFiKBIBchApcpgxDM4BewgMAWDAIViqqPeEAAAAASUVORK5CYII=";
			break;
	}
	
	header('Content-type: image/png');
    echo base64_decode($imgcode);
	exit();
}

function check_db() {
	global $current_db;
	//clearstatcache(); // should not be necessary
	if (!is_writable($current_db)) {
		//print "db is ro";
		return false;
	} else {
		return true;
	}
}


// connect to the system database
if (!is_writable('db/phpsla.sqlite')) die("<br />System database 'phpsla.sqlite' is not writeable by webserver account.");
$sysdbh =& new SPSQLite('db/phpsla.sqlite');
$current_db = $_SESSION['phpSQLiteAdmin_currentdb'];
$current_user = 1;


if (check_db()) {
	$userdbh =& new SPSQLite($current_db);
	// I know this is ugly... time should cure it
	$userdbh2 =& new SPSQLite($current_db);
	$sqliteversion = $userdbh->libVersion();
}


function i18n($defaultstring,$stringid) {
	include('i18n_langs.php');
	global $langid;
	$string = ${'t'.$stringid}[$langid];

	if ( (isset($langid)) && (isset($string)) ) {
		return $string;
	} else {
		return $defaultstring;
	}
}


function print_top_links($current_table) {
global $sqliteversion;
echo<<<EOT
<div id="currentdb">Database: {$_SESSION['phpSQLiteAdmin_currentdb']}</div>
<p class="sqliteversion">SQLite version: $sqliteversion</p>
<br />
<a href="mainframe.php" target="mainframe"><img src="include.php?imgid=database.png" alt="" /> Database Info</a> |
<a href="table_structure.php?object=$current_table" target="mainframe"><img src="include.php?imgid=table_structure.png" alt="" /> Structure</a> |
<a href="table_browse.php?object=$current_table" target="mainframe"><img src="include.php?imgid=table_browse.png" alt="" /> Browse</a> |
<a href="query.php?object=$current_table" target="mainframe"><img src="include.php?imgid=query.png" alt="" /> Query</a> |
<a href="row_edit.php?object=$current_table" target="mainframe"><img src="include.php?imgid=row_insert.png" alt=\"\" /> Insert</a> |
<a href="export.php?object=$current_table" target="mainframe"><img src="include.php?imgid=export.png" alt=\"\" /> Export</a> |
<a href="dbaction.php?action=empty_table&amp;object=$current_table" target="_top" onclick="return confirm_empty_table();"><img src="include.php?imgid=table_empty.png" alt=\"\" /> Empty</a> |
<a href="dbaction.php?action=drop_table&amp;object=$current_table" target="_top" onclick="return confirm_drop_table();"><img src="include.php?imgid=table_drop.png" alt=\"\" /> Drop</a>
EOT;
}


function print_table_action_links($current_table) {
echo<<<EOT
<a href="table_structure.php?object=$current_table" target="mainframe"><img src="include.php?imgid=table_structure.png" alt="" /> Structure</a> |
<a href="table_browse.php?object=$current_table" target="mainframe"><img src="include.php?imgid=table_browse.png" alt="" /> Browse</a> |
<a href="query.php?object=$current_table" target="mainframe"><img src="include.php?imgid=query.png" alt="" /> Query</a> |
<a href="row_edit.php?object=$current_table" target="mainframe"><img src="include.php?imgid=row_insert.png" alt=\"\" /> Insert</a> |
<a href="export.php?object=$current_table" target="mainframe"><img src="include.php?imgid=export.png" alt=\"\" /> Export</a> |
<a href="dbaction.php?action=empty_table&amp;object=$current_table" target="_top" onclick="return confirm_empty_table();"><img src="include.php?imgid=table_empty.png" alt="" /> Empty</a> |
<a href="dbaction.php?action=drop_table&amp;object=$current_table" target="_top" onclick="return confirm_drop_table();"><img src="include.php?imgid=table_drop.png" alt="" /> Drop</a>

EOT;
}


function print_index_action_links($current_index) {
echo<<<EOT
<a href="dbaction.php?action=drop_index&amp;object=$current_index" target="_top" onclick="return confirm_drop_index();">Drop</a>
EOT;
}


function print_db_selector($current_db) {
	global $db_dir,$database,$sysdbh;
	print "<form name=\"choosedb\" action=\"set_session.php\" method=\"post\" target=\"_top\">\n";
	print "<input type=\"hidden\" name=\"sessionname\" value=\"phpSQLiteAdmin_currentdb\" />\n";
	print "<select name=\"sessionvalue\" onchange=\"this.form.submit();\">\n";

	$sysdbh->query("select alias,path from databases order by alias");
	while($row = $sysdbh->fetchArray()) {
		//print $row[0].'-'.$current_db."<br />\n";
		if ($row[1] != $current_db) {
			print '<option value="'.$row[1].'">'.$row[0]."</option>\n";
		} else {
			print '<option value="'.$row[1].'" selected="selected">'.$row[0]."</option>\n";
		}
		// dunno what this is for... remove it later
		$available_dbs[] = $row[0];
	}
	print "</select>\n";
	print "</form>\n";
}


function print_column_types() {
echo<<<EOT
<option value="">typeless</option>
<option value="integer">integer</option>
<option value="float">float</option>
<option value="varchar">varchar</option>
<option value="nvarchar">nvarchar</option>
<option value="text">text</option>
<option value="boolean">boolean</option>
<option value="clob">clob</option>
<option value="blob">blob</option>
<option value="timestamp">timestamp</option>
<option value="numeric">numeric</option>
<option value="varying character">varying character</option>
<option value="national varying character">national varying character</option>
EOT;
}


class dbfile {
	var $name;
	var $device;
	var $inode;
	var $inode_protection_mode;
	var $number_of_links;
	var $uid;
	var $gid;
	var $user;
	var $group;
	var $device_type;
	var $size;
	var $last_access;
	var $last_modification;
	var $last_change;
	var $blocksize;
	var $number_of_blocks;

	function dbfile($name) {
		$this->name = $name;
		$info = stat($this->name);
		$this->device = $info[0];
		$this->inode = $info[1];
		$this->inode_protection_mode = $info[2];
		$this->number_of_links = $info[3];
		$this->uid = $info[4];
		$this->gid = $info[5];
		$this->device_type = $info[6];
		$this->size = $info[7];
		$this->last_access = $info[8];
		$this->last_modification = $info[9];
		$this->last_change = $info[10];
		$this->blocksize = $info[11];
		$this->number_of_blocks = $info[12];

  		// not on windoze
		//$userdata = posix_getpwuid($this->uid);
		//$groupdata = posix_getgrgid($this->gid);
		//$this->user = $userdata['name'];
		//$this->group = $groupdata['name'];

	}
}


class dbalias {
	var $user;
	var $alias;
	var $path;
	var $description;

	function get($user,$alias) {
		// select here and return object
		return 0;
	}

	function insert($user,$alias) {
	}

	/* Strange bug. remove temporarily.
	function update($this) {
	}
	*/
}


// hoster mode init stuff starts here
$dirs = explode('/',$_SERVER['SCRIPT_FILENAME']);

foreach($dirs as $value) {
	$hm_dbpath[] = $value;
	if ($value == $dirs[$hm_userdirposition]) break;
}

$hm_dbpath[] = $hm_dbdir;
$hm_dbpath = implode('/',$hm_dbpath);
// hoster mode stuff ends here
?>
