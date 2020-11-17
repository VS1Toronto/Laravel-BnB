<template>
    <div class="text-center success">
        <i class="far fa-thumbs-up"></i>
        <h1 class="mt-4">Success!</h1>
        <h2>
            <!-- These   <slot></slot>   tags pick up and displays anything from        -->
            <!-- between the   <success></success>   tags in the Review.vue   component -->
            <!-- -->
            <slot></slot>
        </h2>
    </div>
</template>


<style scoped>
.success {
  color: #999;
  font-size: 10rem;
}
</style>