<header class="bg-gray-900">
  <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8">
    <div class="flex lg:flex-1">
      <a href="<?php echo site_url();?>" class="-m-1.5 p-1.5">
        <h1 class="logo-font cinzel-font text-4xl text-white">FOSS</h1>
      </a>
    </div>

    <div class="lg:hidden">
      <button id="mobile-menu-button" class="text-white text-3xl">☰</button>
    </div>

    <div class="hidden lg:flex lg:gap-x-12">
      <a href="<?php echo site_url();?>" class="text-sm/6 font-semibold text-white">Home</a>
      <a href="<?php echo site_url('perpetual-register');?>" class="text-sm/6 font-semibold text-white">Upload</a>
    </div>
  </nav>

<div id="mobile-menu" class="fixed inset-0 z-50 hidden">
  <div class="absolute inset-0 bg-black bg-opacity-50"></div>
  <div class="absolute left-0 top-0 h-full w-full bg-gray-800 p-6 flex flex-col gap-6 z-10">
    <div class="grid grid-cols-2">
      <a href="<?php echo site_url();?>"><h1 class="logo-font cinzel-font text-4xl text-white">FOSS</h1></a>
      <button id="close-menu" class="text-white text-3xl text-right">×</button>
    </div>
    <a href="<?php echo site_url();?>" class="text-white text-lg font-semibold">Home</a>
    <a href="<?php echo site_url('perpetual-register');?>" class="text-white text-lg font-semibold">Upload</a>
  </div>
</div>

</header>

<script>
  const btn = document.getElementById('mobile-menu-button');
  const menu = document.getElementById('mobile-menu');
  const closeBtn = document.getElementById('close-menu');

  btn.addEventListener('click', () => {
    menu.classList.remove('hidden');
  });

  closeBtn.addEventListener('click', () => {
    menu.classList.add('hidden');
  });
</script>

<main class="flex-1">