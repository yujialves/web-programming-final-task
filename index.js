new Vue({
  el: "#app",
  data: {
    inLogin: true,
    user: "",
    password: "",
    passwordToConfirm: "",
  },
  computed: {
    formAction() {
      return this.inLogin ? "auth/login.php" : "auth/register.php";
    },
    title() {
      return this.inLogin ? "ログイン" : "登録";
    },
    bottomText() {
      return this.inLogin ? "始めての方はこちら" : "会員の方はこちら";
    },
    disabled() {
      if (this.user.trim() === "" || this.password.trim() === "") {
        return true;
      }
      if (
        !this.inLogin &&
        this.password.trim() !== this.passwordToConfirm.trim()
      ) {
        return true;
      }
      return false;
    },
  },
});
