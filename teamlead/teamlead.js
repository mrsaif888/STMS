// Load users in dropdown for task assignment
function loadUsersForTaskAssign() {
    fetch("../backend/get_users_for_task.php")
      .then(res => res.json())
      .then(data => {
        const dropdown = document.getElementById("task-assign");
        dropdown.innerHTML = "";
  
        data.users.forEach(user => {
          const option = document.createElement("option");
          option.value = user.id;
          option.textContent = `${user.username} (${user.role})`;
          dropdown.appendChild(option);
        });
      })
      .catch(err => {
        console.error("Failed to load users:", err);
      });
  }
  
  // Create a single task card
  function createTaskCard(task) {
    const taskCard = document.createElement("div");
    taskCard.className = "task-card";
    taskCard.innerHTML = `
      <strong>${task.title}</strong>
      <p>${task.description}</p>
      <p>Priority: ${task.priority}</p>
      <p>Due: ${task.deadline}</p>
      <p>Assigned to: ${task.assigned_username} (${task.assigned_role})</p>
    `;
    return taskCard;
  }
  
  // Load tasks to task board with sorting and grouping
  function loadTasksToBoard() {
    fetch("../backend/get_tasks.php")
      .then(res => res.json())
      .then(data => {
        const todo = document.getElementById("todo-tasks");
        const inProgress = document.getElementById("inprogress-tasks");
        const completed = document.getElementById("completed-tasks");
  
        todo.innerHTML = "";
        inProgress.innerHTML = "";
        completed.innerHTML = "";
  
        const priorityOrder = { high: 1, medium: 2, low: 3 };
  
        // Group tasks by status
        const grouped = { todo: [], inprogress: [], completed: [] };
        data.tasks.forEach(task => {
          if (grouped[task.status]) {
            grouped[task.status].push(task);
          }
        });
  
        // Sort each group by priority
        Object.keys(grouped).forEach(status => {
          grouped[status].sort((a, b) => priorityOrder[a.priority] - priorityOrder[b.priority]);
        });
  
        // Render cards in each column
        grouped.todo.forEach(task => todo.appendChild(createTaskCard(task)));
        grouped.inprogress.forEach(task => inProgress.appendChild(createTaskCard(task)));
        grouped.completed.forEach(task => completed.appendChild(createTaskCard(task)));
      })
      .catch(err => {
        console.error("Failed to load tasks:", err);
      });
  }
  
  // Handle form submission to create a task
  document.getElementById("create-task-form").addEventListener("submit", function (e) {
    e.preventDefault();
  
    const title = document.getElementById("task-title").value;
    const description = document.getElementById("task-desc").value;
    const deadline = document.getElementById("task-deadline").value;
    const priority = document.getElementById("task-priority").value;
    const assignedTo = document.getElementById("task-assign").value;
  
    fetch("../backend/create_task.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: new URLSearchParams({
        title,
        description,
        deadline,
        priority,
        assigned_to: assignedTo
      })
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          alert("✅ Task created!");
          loadTasksToBoard();
          document.getElementById("create-task-form").reset();
        } else {
          alert("❌ Task creation failed: " + data.message);
        }
      })
      .catch((err) => {
        console.error("Create Task Error:", err);
      });
  });
  
  // Run on page load
  document.addEventListener("DOMContentLoaded", () => {
    loadUsersForTaskAssign();
    loadTasksToBoard();
  });
  function createTaskCard(task) {
    const card = document.createElement("div");
    card.className = "task-card";
    card.draggable = true;
    card.id = `task-${task.id}`;
  
    card.addEventListener("dragstart", e => {
      e.dataTransfer.setData("text/plain", task.id);
    });
  
    card.innerHTML = `
      <strong>${task.title}</strong>
      <p>${task.description}</p>
      <p>Priority: ${task.priority}</p>
      <p>Due: ${task.deadline}</p>
      <p>Assigned to: ${task.assigned_username} (${task.assigned_role})</p>
      <div class="task-actions">
        <button onclick="editTask(${task.id})">✏️ Edit</button>
        <button onclick="deleteTask(${task.id})">🗑️ Delete</button>
      </div>
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
  
  function updateTaskStatus(taskId, status) {
    fetch("../backend/updateTaskStatus.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: new URLSearchParams({
        task_id: taskId,
        status: status
      })
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          loadTasksToBoard();
        } else {
          alert("Failed to update task status.");
        }
      })
      .catch(err => console.error("Error updating status:", err));
  }
  
  function deleteTask(taskId) {
    if (!confirm("Are you sure you want to delete this task?")) return;
  
    fetch("../backend/delete_task.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: new URLSearchParams({ task_id: taskId })
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          loadTasksToBoard();
        } else {
          alert("Delete failed.");
        }
      });
  }
  
  function editTask(taskId) {
    console.log("Opening edit modal for task:", taskId); // 🔍 debug log
    fetch(`../backend/get_task_by_id.php?task_id=${taskId}`)
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          const task = data.task;
  
          document.getElementById("edit-task-id").value = task.id;
          document.getElementById("edit-task-title").value = task.title;
          document.getElementById("edit-task-desc").value = task.description;
          document.getElementById("edit-task-deadline").value = task.deadline;
          document.getElementById("edit-task-priority").value = task.priority;
  
          loadUsersForEditDropdown(task.assigned_to); // fills assign dropdown
  
          // ✅ This line actually opens the modal:
          document.getElementById("edit-modal").classList.remove("hidden");
        } else {
          alert("Could not load task.");
        }
      });
  }
  function loadUsersForEditDropdown(selectedUserId) {
    fetch("../backend/get_users_for_task.php")
      .then(res => res.json())
      .then(data => {
        const dropdown = document.getElementById("edit-task-assign");
        dropdown.innerHTML = "";
  
        data.users.forEach(user => {
          const option = document.createElement("option");
          option.value = user.id;
          option.textContent = `${user.username} (${user.role})`;
          if (user.id == selectedUserId) {
            option.selected = true;
          }
          dropdown.appendChild(option);
        });
      })
      .catch(err => {
        console.error("Failed to load users for edit dropdown:", err);
      });
     
      
      document.getElementById("edit-modal").style.display = "block";
  }
 
  function closeEditModal() {
    const modal = document.getElementById("edit-modal");
    if (modal) {
      modal.style.display = "none";
    }
  }
  document.getElementById("edit-task-form").addEventListener("submit", function (e) {
    e.preventDefault();
  
    const id = document.getElementById("edit-task-id").value;
    const title = document.getElementById("edit-task-title").value;
    const description = document.getElementById("edit-task-desc").value;
    const deadline = document.getElementById("edit-task-deadline").value;
    const priority = document.getElementById("edit-task-priority").value;
    const assigned_to = document.getElementById("edit-task-assign").value;
  
    fetch("../backend/update_task.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: new URLSearchParams({
        id,
        title,
        description,
        deadline,
        priority,
        assigned_to
      })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("✅ Task updated successfully!");
        closeEditModal();
        loadTasksToBoard(); // refresh tasks
      } else {
        alert(" Failed to update task: " + data.message);
      }
    })
    .catch(err => {
      console.error("Edit Task Error:", err);
    });
  });

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
        loadTasksToBoard();
        notifyUser(`✅ Task moved to "${newStatus.toUpperCase()}"`);
      } else {
        alert("Failed to update task status.");
      }
    })
    .catch(err => {
      console.error("Status update error:", err);
    });
  }
  
  function notifyUser(message) {
    const toast = document.getElementById("notification");
    if (!toast) return;
  
    toast.innerText = message;
    toast.style.display = "block";
  
    setTimeout(() => {
      toast.style.display = "none";
    }, 3000);
  }
  
  document.getElementById("signout-btn").addEventListener("click", () => {
    window.location.href = "../backend/logout.php";
  });
  

    