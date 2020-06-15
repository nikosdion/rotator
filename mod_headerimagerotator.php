<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

// Make sure mooTools is loaded
JHTML::_('behavior.mootools');

// Get parameters
$moduleclass_sfx =	$params->get( 'moduleclass_sfx',	'' );
$uniqueid =			$params->get( 'uniqueid',			'rotate' );
$imagefolder =		$params->get( 'imagefolder',		'fruit' );
$speed =			$params->get( 'speed',				2 );
$timeout =			$params->get( 'timeout',			5 );
$width =			$params->get( 'width',				140 );
$height =			$params->get( 'height',				105 );
$opacity =			$params->get( 'opacity',			25 );
$display =			$params->get( 'display',			0 );

// Scan folder
$folder = JPATH_ROOT . DS . 'images' . DS . 'stories' . DS . implode(DS, explode('/', str_replace("\\", "/", $imagefolder)));
$images = glob( $folder . DS . '{*.jpg,*.gif,*.png,*.bmp}', GLOB_BRACE );
$hasImages = count($images) > 0;

if( $hasImages )
{
?>
<script language="javascript" src="mootools-release-1.11.js"></script>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */
var delayLen = <?php echo $timeout; ?>;	// Delay length in seconds
var transLen = <?php echo $speed; ?>;	// Transition length in seconds
var maxID = <?php echo count($images) ?>;		// Max no. of pictures
var tag = '<?php echo $uniqueid; ?>';		// Unique tag for module

var currentID = 0;	// Current image being displayed

function show( id ){
	if( (id - 1) <= 0 )
	{
		oldID = maxID;
	} else {
		oldID = id - 1;
	}
	
	vDiv = tag + id;
	tDiv = tag + oldID;
	
	if($(tDiv).fx){$(tDiv).fx.stop();}
	if($(vDiv).fx){$(vDiv).fx.stop();}
	$(tDiv).fx = $(tDiv).effect('opacity', {duration: transLen * 1000}).start(0);
	$(vDiv).fx = $(vDiv).effect('opacity', {duration: transLen * 1000}).start(<?php echo number_format($opacity / 100, 2, '.', ','); ?>);	
}

function showNext()
{
	currentID++;
	if( currentID > maxID )
	{
		currentID = 1;
	}
	show( currentID );
}

window.setInterval("showNext()", (delayLen + transLen) * 1000);
showNext();
/* ]]> */
</script>

<?php
	switch($display)
	{
		case 0:
			$style = 'float: right;';
			break;
		case 1:
			$style = 'float: left;';
			break;
		case 2:
		default:
			$style = '';
			break;
	}
?>

<div id="<?php echo $uniqueid; ?>" style="<?php echo $style; ?> height:<?php echo $height; ?>px; width: <?php echo $width; ?>px;">
<?php
	$i = 0;
	foreach( $images as $img )
	{
		$i++;
?>
		<div id="<?php echo $uniqueid . $i; ?>" style="position:absolute; float: left; filter:alpha(opacity=0); -moz-opacity:0; opacity: 0;"><img src="images/stories/<?php echo $imagefolder . '/' . basename($img); ?>" height="<?php echo $height; ?>" width="<?php echo $width; ?>" /></div>
<?php
	}
?>
</div>
<?php
}
?>