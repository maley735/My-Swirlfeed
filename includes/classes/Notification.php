<?php
	class Notification {
		private $user_obj;
		private $con;

		public function __construct($con, $user){
			$this->con = $con;
			$this->user_obj = new User($con, $user);
		}

		public function getUnreadNumber() {
			$userLoggedIn = $this->user_obj->getUsername();
			$query = mysqli_query($this->con, "SELECT * FROM notifications WHERE viewed='no' AND user_to='$userLoggedIn'");
			return mysqli_num_rows($query);
		}

		public function insertNotification($post_id, $user_to, $type){
			$userLoggedIn = $this->user_obj->getUsername();
			$userLoggenInName =  $this->user_obj->getFirstAndLastName();

			$date_time = date("Y-m-d H:i:s");

			switch($type){
				case 'comment': 
					$message = $userLoggenInName . " commented on your post";
					break;
				case 'like': 
					$message = $userLoggenInName . " liked your post";
					break;
				case 'profile_post': 
					$message = $userLoggenInName . " posted on your profile";
					break;
				case 'comment_non_owner': 
					$message = $userLoggenInName . " commented on a post you commented on";
					break;
				case 'profile_comment': 
					$message = $userLoggenInName . " commented on your profile post";
					break;
			}

			$link = "post.php?id=" . $post_id;

			$insert_query = mysqli_query($this->con, "INSERT INTO notifications VALUES ('', '$user_to', '$userLoggedIn', '$message', '$link', '$date_time', 'no', 'no' )");
		}
	}
?>

