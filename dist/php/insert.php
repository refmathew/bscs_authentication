<?php
echo '
  <div class="main__page__insert-page main__page__page">
    <h2 class="main__page__header main__page__insert-page__header">Insert Record</h2>
    <form class="main__page__form main__page__insert-page__form" action="include/insert.inc.php" method="POST">
      <input class="main__page__insert-page__form__username" type="text" name="user_name" placeholder="Username..." />
      <input class="main__page__insert-page__form__password" type="password" name="user_password" placeholder="Password..." />
      <div class="main__page__insert-page__form__admin">
          <input type="hidden" value="0" name="user_isAdmin" />
          <input class="main__page__insert-page__form__admin__checkbox" type="checkbox" value="1" name="user_isAdmin" id="user_isAdmin"  />
          <label for="user_isAdmin" class="main__page__insert-page__form__admin__label">Admin</label>
      </div>
      <button class="login-section__form__login-button" type="submit" name="insert">
        Insert
      </button>
'
?>

<?php
if (isset($_GET["error"])) {
  if ($_GET["error"] == "incomplete_credentials") {
    echo '<p class="error-message">Please enter complete credentials!</p>';
  } elseif ($_GET["error"] == "username_exists") {
    echo '<p class="error-message">Username already taken...</p>';
  }
}
if (isset($_GET["insert_record"])) {
  if ($_GET["insert_record"] == "success") {
    echo '<p class="success-message">Inserted succesfully!</p>';
  } elseif ($_GET["insert_record"] == "failed") {
    echo '<p class="error-message">Record not inserted...</p>';
  }
}
?>

<?php
echo '
    </form>
  </div>
';
