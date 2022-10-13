<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  <title>Home</title>
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
      <h2 class="text-3xl font-semibold">Activity</h2>
      <button id="open" class="px-4 py-3 bg-blue-400 rounded-xl text-white font-base">
        <i class="fa-solid fa-plus"></i>
        Add activity
      </button>
    </div>
    <div class="mt-6 flex flex-wrap">
      @foreach ($activities as $activity)
      <div class="flex flex-col justify-between h-40 w-52 bg-white rounded-xl pl-3 py-3 mr-5 mt-3">
        <a href="/detail/<?php echo $activity->id;?>"
          class="text-lg font-semibold hover:underline">{{$activity->name}}</a>
        <p class="text-base">{{$activity->created_at}}
          <a href="/activity/delete/<?php echo $activity->id;?>"
            onclick="return confirm('Are you sure you want to delete this activity ? (all tasks in this activity will be deleted)')"><i
              class="fa-solid fa-trash ml-5"></i></a>
        </p>
      </div>
      @endforeach
    </div>
  </div>
  <!-- end container -->

  <!-- modal -->
  <div class="container bg-gray-100 relative">
    <div class="modal w-1/3 h-1/4 bg-white rounded-xl">
      <div class="bg-blue-500 py-3 rounded-xl text-center">
        <h2 class="text-xl font-semibold text-white">Form Add New Activity</h2>
      </div>
      <form action="/activity/store" method="post" class="px-16 mt-2">
        <table>
          @csrf
          <tr>
            <td>Activity Name:</td>
            <td>
              <input type="text" name="activity_name" class="border-gray-300 border-2 px-2 py-1 ">
            </td>
          </tr>
          <tr>
            <td align="center" colspan="2">
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

</body>

</html>

<script>
let modalEl = document.querySelector('.container');
let closeBtn = document.querySelector('#close');
let openBtn = document.querySelector('#open');

closeBtn.addEventListener('click', function() {
  modalEl.style.display = 'none';
});


openBtn.addEventListener('click', function() {
  modalEl.style.display = 'block';
});
</script>