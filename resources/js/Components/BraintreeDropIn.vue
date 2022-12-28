<script setup>
import BraintreeDropInVue from 'braintree-dropin-vue'
</script>
<template>
  <BraintreeDropInVue
      containerId="braintree-dropin-container"
      :createTransaction="createTransaction"
      :createToken="createToken"
      :options="braintreeOptions"
      :onCreate="onCreate"
      :onDestroyStart="onDestroyStart"
      :onDestroyEnd="onDestroyEnd"
      :onError="onError"
    ></BraintreeDropInVue>
</template>
