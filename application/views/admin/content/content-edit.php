<?php $this->load->view('admin/header'); ?>

<?php $this->load->view('admin/side-menu'); ?>

<div class="span-17 last">
<h1><?php echo $title; ?></h1>

<!-- CONTENT FORM -->

<?php echo validation_errors('<p class="error" >'); ?>
<?php if ($this->message->display('success')): echo '<p class="success">'.$this->message->display('success').'</p>'; endif; ?>

<?php echo form_open('admin/content/save/'); ?>
	<p>
		<label for="title">Title</label>
		<input type="text" class="title" name="title" id="name" value="<?php if(isset($formdata)){ echo $formdata->title; } ?>" />
	</p>
	<p>
		<label for="title">Content</label>
		<textarea class="ckeditor title" name="content" id="ckeditor"><?php if(isset($formdata)){ echo $formdata->content; } ?></textarea>
	</p>
	<p>
		<label for="title">Status</label>
		<?php $active = NULL; $nonactive = NULL; if($formdata->status == 1){ $active = TRUE; } else { $nonactive = TRUE; } ?>
		<?php echo form_radio('status', '1', $nonactive); ?>
		Published
		<?php echo form_radio('status', '0', $active); ?>
		Not Published
	</p>
<?php if($formdata->lft == '1'): ?>
<?php echo form_hidden('position', $formdata->lft); ?>
<?php else: ?>
	<p>
		<label for="title">Select Parent Page</label>
		<select name="position">
			<?php if(isset($parent)): ?>
			<?php echo "<option value=\"".$parent->lft."\">".$parent->title."</option>";?>
			<option value="">--------------------</option>
			<?php endif; ?>
			<?php if(isset($root)){echo "<option value=\"".$root['lft']."\">".$root['title']."</option>"; }?>			
 			<?php if(isset($children)){ tree($children, "2"); }?>
		</select>
	</p>
<?php endif; ?>	

<?php 

function tree($array, $formdata)
{
	foreach($array as $child)
	{
		echo "<option value=\"".$child['lft']."\">".$child['title']."</option>";

		if(isset($child['children']))
		{
				tree($child['children'], $child['lft']);
		}
	}
}

?>
	<p>
		<label for="title">Image Gallery</label>
		<select name="gallery">
		<?php if($formdata->gallery != 0) {?>
		<?php echo "<option value=".$formdata->gallery.">".$formdata->name."</option>"; ?>
			<option value="">---------------</option>
		<?php } ?>
			<option value="0">No Gallery Linked</option>
		<?php foreach($galleries as $gallery) {
					echo "<option value=".$gallery->id.">".$gallery->name."</option>";
		} ?>		
		</select>
	</p>

	<p>
		<label for="title">Author</label>
		<select name="author">
		<?php if($formdata->userid) {?>
		<?php echo "<option value=".$formdata->userid.">".$formdata->firstname." ".$formdata->lastname."</option>"; ?>
			<option value="">---------------</option>
		<?php } ?>
<?php foreach($users as $user) {
    echo "<option value=".$user->userid.">".$user->firstname." ".$user->lastname."</option>";
}?>		</select>
	</p>
	<p>
		<label for="title">Post Date</label>
		<input type="text" class="text" name="date_created" id="date_created" value="<?php if(isset($formdata)){ echo date("Y-m-d", strtotime($formdata->date_created)); } ?>" />
	</p>
	<p>
		<?php if(isset($formdata) && $formdata->id != NULL){ echo form_hidden('id', $formdata->id); } ?>
		<?php if(isset($formdata)){ echo form_hidden('type', $formdata->type); } ?>
		<?php if(isset($formdata)){ echo form_hidden('nested', $formdata->nested); } ?>
		<?php if(isset($formdata)){ echo form_hidden('lft', $formdata->lft); } ?>
		<button type="submit" class="positive">Save</button>
	</p>
<?php echo form_close(); ?>
</div>

<script type="text/javascript" language="javascript">
CKEDITOR.replace( 'ckeditor',
    {
		filebrowserBrowseUrl : '<?php echo site_url('admin/media/browse/files');?>',
        filebrowserUploadUrl : '<?php echo site_url('admin/media/upload/');?>',
		filebrowserImageBrowseUrl : '<?php echo site_url('admin/media/browse/images');?>',
		filebrowserWindowWidth : '800',
        filebrowserWindowHeight : '805',
		//filebrowserFlashBrowseUrl :'js/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=http://www.mixedwaves.com/filemanager_in_ckeditor/js/ckeditor/filemanager/connectors/php/connector.php',
        toolbar : 'Content',
        height: '500px'
    });
    
    CKEDITOR.on( 'dialogDefinition', function( ev )
   {
      // Take the dialog name and its definition from the event
      // data.
      var dialogName = ev.data.name;
      var dialogDefinition = ev.data.definition;

      // Check if the definition is from the dialog we're
      // interested on (the Link and Image dialog).
      if ( dialogName == 'link' || dialogName == 'image' )
      {
         // remove Upload tab
         dialogDefinition.removeContents( 'Upload' );
      }
   });
</script>
<script type="text/javascript">
	$(function() {
		$("#date_created").datepicker({ dateFormat: 'yy-mm-dd' });
	});
</script>      	

<?php $this->load->view('admin/footer'); ?>