new Vue({
  el: "#app",
  data: {
    showAddModal: false,
    showEditModal: false,
    id: null,
    begin: "",
    end: "",
    title: "",
    content: "",
    inner_todos: [],
  },
  methods: {
    cancel() {
      this.showAddModal = false;
      this.showEditModal = false;
      this.id = null;
      this.begin = "";
      this.end = "";
      this.title = "";
      this.content = "";
    },
    editTodo(todo) {
      this.id = todo.id;
      this.begin = todo.begin.replace(" ", "T");
      this.end = todo.end.replace(" ", "T");
      this.title = todo.title;
      this.content = todo.content;
      this.showEditModal = true;
    },
    register: async function () {
      if (
        this.begin.trim() === "" ||
        this.end.trim() === "" ||
        this.title.trim() === ""
      ) {
        return;
      }
      const formData = new FormData();
      formData.append("begin", this.begin);
      formData.append("end", this.end);
      formData.append("title", this.title);
      formData.append("content", this.content);
      const response = await fetch("../api/register.php", {
        method: "POST",
        body: formData,
      });
      const data = await response.json();
      this.inner_todos = data;
      this.id = null;
      this.begin = "";
      this.end = "";
      this.title = "";
      this.content = "";
      this.showAddModal = false;
    },
    update: async function () {
      if (
        this.id === null ||
        this.begin.trim() === "" ||
        this.end.trim() === "" ||
        this.title.trim() === ""
      ) {
        return;
      }
      const formData = new FormData();
      formData.append("id", this.id);
      formData.append("begin", this.begin);
      formData.append("end", this.end);
      formData.append("title", this.title);
      formData.append("content", this.content);
      const response = await fetch("../api/update.php", {
        method: "POST",
        body: formData,
      });
      const data = await response.json();
      this.inner_todos = data;
      this.id = null;
      this.begin = "";
      this.end = "";
      this.title = "";
      this.content = "";
      this.showEditModal = false;
    },
    remove: async function (id) {
      if (id.trim() == "") {
        return;
      }
      const formData = new FormData();
      formData.append("id", id);
      const response = await fetch("../api/remove.php", {
        method: "POST",
        body: formData,
      });
      const data = await response.json();
      this.inner_todos = data;
    },
    toggle: async function (id) {
      if (id.trim() == "") {
        return;
      }
      const formData = new FormData();
      formData.append("id", id);
      const response = await fetch("../api/toggle.php", {
        method: "POST",
        body: formData,
      });
      const data = await response.json();
      this.inner_todos = data;
    },
  },
  computed: {
    todos() {
      return this.inner_todos.map((todo) => {
        return {
          ...todo,
          removeBtnId: `remove-btn-${todo.id}`,
          updateBtnId: `update-btn-${todo.id}`,
        };
      });
    },
    checkedTodos() {
      return this.todos.filter((todo) => {
        return todo.complete !== "0";
      });
    },
    nonCheckedTodos() {
      return this.todos.filter((todo) => {
        return todo.complete === "0";
      });
    },
  },
  created: async function () {
    const response = await fetch("../api/fetch.php");
    const data = await response.json();
    this.inner_todos = data;
  },
  filters: {
    dateFormat(date) {
      return date.slice(5, 16).replace("-", "/");
    },
  },
});
