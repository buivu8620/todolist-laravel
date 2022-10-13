<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  <title>Detail</title>
</head>
<style>
.container {
  width: 100vw;
  height: 100vh;
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgb(0, 0, 0);
  background-color: rgba(0, 0, 0, 0.4)
}

.modal {
  position: absolute;
  top: 50%;
  left: 50%;

  transform: translate(-50%, -50%);
}

td {
  padding: 8px 8px;
}
</style>

<body class="bg-gray-200">
  <!-- header -->
  <div class="w-full h-20 bg-blue-500 flex justify-start items-center pl-16">
    <h1 class="text-white text-2xl font-semibold">
      Todo List App
    </h1>
  </div>
  <!-- end header -->

  <!-- container -->
  <div class="w-full px-52 mt-4 ">
    <div class="flex justify-between">
      <div class="flex items-center">
        <a href="/"><i class="fa-solid fa-chevron-left text-2xl"></i></a>
        <form action="/activity/update/<?php echo isset($activity) ?$activity->id : '';?>" method="post" class="w-1/3"
          id="form">
          @csrf
          <input type="text" name="activity_name" value="{{isset($activity) ? $activity->name : ''}}" disabled
            id="activity-id" class="pl-2 text-2xl font-semibold mx-5 bg-transparent w-full"></input>
        </form>
        <span id="edit-btn" class="cursor-pointer ml-7"><i class="fa-solid fa-pencil text-lg"></i></span>
      </div>
      <button id="open" class="px-4 py-3 bg-blue-400 rounded-xl text-white font-base"><i class="fa-solid fa-plus"></i>
        Add
        task</button>
    </div>
    <div class="mt-10 flex flex-wrap w-full">
      @foreach($tasks as $task)
      <div class="flex justify-between w-full items-center bg-white py-3 px-5 rounded-xl mb-4">
        <div class="flex items-center justify-start">
          <!-- {{$task->name}} -->
          <form action="/task/update/<?php echo isset($task) ? $task->id: ''?>" method="post"
            class="flex items-center form-task w-auto">
            @csrf
            <input type="checkbox" name="status" id="status" value=""
              <?php echo ($task->status == 1 ? 'checked ' : '');?> style="width:20px;height:20px">
            <input type="text" name="task_name" value="{{isset($task) ? $task->name : ''}}" disabled
              class="pl-2 text-2xl font-semibold mx-5 bg-transparent w-full task-id"></input>
            <input type="hidden" name="activity_id" value="{{$activity->id}}">
          </form>
          <span class="cursor-pointer block edit-task"><i class="fa-solid fa-pencil text-base ml-2"></i></span>
          <span class="cursor-pointer block ml-3 open-detail"><i class="fa-solid fa-eye"></i></span>

        </div>
        <a href="/task/delete/<?php echo $task->id;?>"
          onclick="return confirm('Are you sure you want to delete this task')"><i
            class="fa-solid fa-trash ml-5"></i></a>

      </div>
      @endforeach

    </div>
  </div>
  <!-- end container -->

  <!-- modal -->
  <div class="container bg-gray-100 relative">
    <div class="modal w-1/3 h-1/3 bg-white rounded-xl">
      <div class="bg-blue-500 py-3 rounded-xl text-center">
        <h2 class="text-xl font-semibold text-white">Form add a new task</h2>
      </div>
      <form action="/task/store" method="post" class="px-16 mt-2">
        <table>
          @csrf
          <tr>
            <td>Task Name:</td>
            <td>
              <input type="text" name="task_name" class="border-gray-300 border-2 px-2 py-1 ">
            </td>
          </tr>
          <tr>
            <td>Status:</td>
            <td>
              <select name="status" id="" class="border-gray-300 border-2 px-2 py-1 ">
                <option value="0">-- Pending --</option>
                <option value="1">-- Done --</option>
              </select>
            </td>
          </tr>
          <input type="hidden" name="activity_id" value="{{isset($activity) ?$activity->id : ''}}">
          <tr>
            <td align=" center" colspan="2">
              <input type="submit" value="Save" class="px-4 py-2 bg-blue-400 rounded-lg cursor-pointer mr-4">
              <span id="close" class="px-4 py-2 bg-red-500 rounded-lg ml-4 cursor-pointer">Close</span>
            </td>
            <!-- <td align="center">

            </td> -->
          </tr>
        </table>
      </form>
    </div>

  </div>
  <!-- end modal -->

  <!-- modal view -->
  @foreach ($tasks as $task)
  <div class="container bg-gray-100 relative view-modal detail-model">
    <div class="modal w-1/3 h-auto bg-white rounded-xl pb-5">
      <div class="bg-blue-500 py-2 rounded-xl flex justify-between px-4">
        <h2 class="text-2xl font-semibold text-white">Detail</h2>
        <span class="text-2xl text-red-500 cursor-pointer close-detail"><i class="fa-solid fa-x"></i></span>
      </div>
      <div class="flex flex-col pl-10 mt-2">
        <p class="text-lg">- Task Name: {{$task->name}}</p>
        <p class="text-lg">- Status: @if ($task->status == 1)
          Done
          @else
          Pending
          @endif</p>
      </div>
    </div>
  </div>
  @endforeach
  <!-- end modal view -->
</body>

<script>
let editBnt = document.getElementById('edit-btn');
let input = document.getElementById('activity-id');
let form = document.getElementById('form');

editBnt.addEventListener('click', function() {
  input.disabled = false;
  input.focus();
})

let modalEl = document.querySelector('.container');
let closeBtn = document.querySelector('#close');
let openBtn = document.querySelector('#open');

closeBtn.addEventListener('click', function() {
  modalEl.style.display = 'none';
});


openBtn.addEventListener('click', function() {
  modalEl.style.display = 'block';
});

let editTasks = document.querySelectorAll('.edit-task');
let inputTasks = document.querySelectorAll('.task-id');
let checkbox = document.querySelectorAll("#status");

for (let i = 0; i < editTasks.length; i++) {
  if (checkbox[i].checked) {
    // console.log(inputTasks[i]);
    inputTasks[i].style.textDecoration = 'line-through';
  }
  editTasks[i].addEventListener('click', function() {
    inputTasks[i].disabled = false;
    inputTasks[i].focus();
  })
}
let formTasks = document.querySelectorAll('.form-task');
for (let i = 0; i < checkbox.length; i++) {
  checkbox[i].addEventListener('change', () => {
    if (checkbox[i].checked) {
      checkbox[i].value = 1;
    } else {
      checkbox[i].value = 0;
    }
    inputTasks[i].disabled = false;
    formTasks[i].submit();
  })
}

let detailModels = document.querySelectorAll('.detail-model');
let closeDetailModels = document.querySelectorAll('.close-detail');
let openDetailModels = document.querySelectorAll('.open-detail')
for (let i = 0; i < openDetailModels.length; i++) {
  openDetailModels[i].addEventListener('click', function() {
    detailModels[i].style.display = 'block';
  })
}
for (let i = 0; i < closeDetailModels.length; i++) {
  closeDetailModels[i].addEventListener('click', function() {
    detailModels[i].style.display = 'none';
  })
}
</script>