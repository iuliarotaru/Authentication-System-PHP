<?php
// Image upload
$valid_extensions = ['png', 'jpg', 'jpeg', 'gif', 'zip', 'pdf'];
$image_type = mime_content_type($_FILES['my_profile_image']['tmp_name']); // image/png
$extension = strrchr( $image_type , '/'); // /png ... /tmp ... /jpg
$extension = ltrim($extension, '/'); // png ... jpg ... plain
if( ! in_array($extension, $valid_extensions) ){
    echo "mmm.. hacking me?";
    exit();
}