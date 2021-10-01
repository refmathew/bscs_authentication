<?php
echo '
<div class="main__page__view-page main__page__page">
  <h2 class="main__page__header main__page__view-page__header">View Records</h2>
  <div class="main__page__view-page__table-wrapper">
    <table class="main__page__view-page__table-wrapper__table">
      <tr>
        <th>Id</th>
        <th>Username</th>
        <th>Password</th>
        <th>Admin</th>
        <th>Deleted</th>
        <th>Registration Date</th>
      </tr> 
'
?>

<?php
include_once 'include/view.inc.php';
?>

<?php
echo '
    </table>
  </div>
</div>
';
