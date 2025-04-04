
function loadUserTasks() {
    fetch("../backend/get_user_tasks.php")
      .then(res => res.json())
      .then(data => {
        const todo = document.getElementById("todo-tasks");
        const inProgress = document.getElementById("inprogress-tasks");
        const completed = document.getElementById("completed-tasks");
  
        todo.innerHTML = "";
        inProgress.innerHTML = "";
        completed.innerHTML = "";
  
        const priorityOrder = { high: 1, medium: 2, low: 3 };
        const grouped = { todo: [], inprogress: [], completed: [] };
  
        data.tasks.forEach(task => {
          if (grouped[task.status]) {
            grouped[task.status].push(task);
          }
        });
  
        Object.keys(grouped).forEach(status => {
          grouped[status].sort((a, b) => priorityOrder[a.priority] - priorityOrder[b.priority]);
        });
  
        grouped.todo.forEach(task => todo.appendChild(createTaskCard(task)));
        grouped.inprogress.forEach(task => inProgress.appendChild(createTaskCard(task)));
        grouped.completed.forEach(task => completed.appendChild(createTaskCard(task)));
      })
      .catch(err => {
        console.error("Failed to load user tasks:", err);
      });
  }
  function loadTasksToBoard() {
    fetch("../backend/get_tasks_for_user.php")
      .then(res => res.json())
      .then(data => {
        const todo = document.getElementById("todo-tasks");
        const inProgress = document.getElementById("inprogress-tasks");
        const completed = document.getElementById("completed-tasks");
  
        todo.innerHTML = "";
        inProgress.innerHTML = "";
        completed.innerHTML = "";
  
        const priorityOrder = { high: 1, medium: 2, low: 3 };
  
        // Group tasks
        const grouped = { todo: [], inprogress: [], completed: [] };
        data.tasks.forEach(task => {
          if (grouped[task.status]) {
            grouped[task.status].push(task);
          }
        });
  
        // Sort and render
        Object.entries(grouped).forEach(([status, tasks]) => {
          tasks.sort((a, b) => priorityOrder[a.priority] - priorityOrder[b.priority]);
          tasks.forEach(task => renderTaskCard(task, document.getElementById(`${status}-tasks`)));
        });
      })
      .catch(err => console.error("Failed to load tasks:", err));
  }
  
  function createTaskCard(task) {
    const card = document.createElement("div");
    card.className = "task-card";
    card.innerHTML = `
      <strong>${task.title}</strong>
      <p>${task.description}</p>
      <p>Priority: ${task.priority}</p>
      <p>Due: ${task.deadline}</p>
    `;
    return card;
  }
  
  document.addEventListener("DOMContentLoaded", () => {
    loadUserTasks();
  });
  function createTaskCard(task) {
    const card = document.createElement("div");
    card.className = "task-card";
    card.draggable = true;
    card.id = `task-${task.id}`;
  
    card.addEventListener("dragstart", (e) => {
      e.dataTransfer.setData("text/plain", task.id);
    });
  
    card.innerHTML = `
      <strong>${task.title}</strong>
      <p>${task.description}</p>
      <p>Priority: ${task.priority}</p>
      <p>Due: ${task.deadline}</p>
    `;
    return card;
  }
  function allowDrop(e) {
    e.preventDefault();
  }
  
  function drop(e, newStatus) {
    e.preventDefault();
    const taskId = e.dataTransfer.getData("text/plain");
    updateTaskStatus(taskId, newStatus);
  }
  function renderTaskCard(task, container) {
    const card = document.createElement("div");
    card.className = "task-card";
    card.draggable = true;
    card.id = `task-${task.id}`;
    card.innerHTML = `
      <strong>${task.title}</strong>
      <p>${task.description}</p>
      <p>Priority: ${task.priority}</p>
      <p>Due: ${task.deadline}</p>
    `;
  
    card.addEventListener("dragstart", e => {
      e.dataTransfer.setData("text/plain", task.id);
    });
  
    container.appendChild(card);
  }
  
  function updateTaskStatus(taskId, newStatus) {
    fetch("../backend/updateTaskStatus.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: new URLSearchParams({
        task_id: taskId,
        status: newStatus
      })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        loadTasksToBoard(); // Refresh the board
        notifyUser(`Task moved to ${newStatus.toUpperCase()}`);
      } else {
        console.error("Update failed:", data.message);
      }
    })
    .catch(err => {
      console.error("Status update error:", err);
    });
  }
  function renderTaskCard(task, container) {
  const card = document.createElement("div");
  card.className = "task-card";
  card.draggable = true;
  card.id = `task-${task.id}`;
  card.innerHTML = `
    <strong>${task.title}</strong>
    <p>${task.description}</p>
    <p>Priority: ${task.priority}</p>
    <p>Due: ${task.deadline}</p>
  `;

  card.addEventListener("dragstart", e => {
    e.dataTransfer.setData("text/plain", task.id);
  });

  container.appendChild(card);
}

  function notifyUser(message) {
    const toast = document.getElementById("notification");
    if (!toast) return;
  
    toast.innerText = message;
    toast.style.display = "block";
  
    setTimeout(() => {
      toast.style.display = "none";
    }, 3000); // 3 seconds
  }
      
  document.getElementById("signout-btn").addEventListener("click", () => {
    window.location.href = "../backend/logout.php";
  });
  