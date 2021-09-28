<?php

$name = $_SESSION['user_name'];

echo "
  <img src='https://avatars.dicebear.com/api/initials/$name.svg' class='nav__avatar__img'/>
";
