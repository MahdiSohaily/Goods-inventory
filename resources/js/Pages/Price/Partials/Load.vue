<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CodeInfo from "./CodeInfo.vue";
import RelationsDetails from "./RelationsDetails.vue";
import GivenPrice from "./GivenPrice.vue";
import Estelam from "./Estelam.vue";

const props = defineProps({
  codes: Array,
  customer: String,
  completeCode: String,
});




</script>

<template>
  <AppLayout title="Rates">
    <div v-for="code of props.codes" class="grid grid-cols-1 md:grid-cols-10 gap-6 lg:gap-2 lg:p-2">
      <CodeInfo :id="code.id" :partNumber="code.partnumber" />
      <!-- <RelationsDetails />
                      <GivenPrice :customer="1" :partNumber="null" :completeCode="null" />
                      <Estelam /> -->
    </div>
    <div class="accordion">
      <!--  Panel 1  -->
      <div>
        <input type="checkbox" name="panel" id="panel-1" class="hidden">
        <label for="panel-1" class="relative block bg-black text-white p-4 shadow border-b border-grey"></label>
        <div class="accordion__content overflow-hidden bg-grey-lighter">
          <p class="accordion__body p-4" id="panel1">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto
            possimus at a cum saepe molestias modi illo facere ducimus voluptatibus praesentium deleniti fugiat ab error
            quia sit perspiciatis velit necessitatibus.Lorem ipsum dolor sit amet, consectetur
            adipisicing elit. Lorem ipsum dolor sit amet.
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto
            possimus at a cum saepe molestias modi illo facere ducimus voluptatibus praesentium deleniti fugiat ab error
            quia sit perspiciatis velit necessitatibus.Lorem ipsum dolor sit amet, consectetur
            adipisicing elit. Lorem ipsum dolor sit amet.
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto
            possimus at a cum saepe molestias modi illo facere ducimus voluptatibus praesentium deleniti fugiat ab error
            quia sit perspiciatis velit necessitatibus.Lorem ipsum dolor sit amet, consectetur
            adipisicing elit. Lorem ipsum dolor sit amet.
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto
            possimus at a cum saepe molestias modi illo facere ducimus voluptatibus praesentium deleniti fugiat ab error
            quia sit perspiciatis velit necessitatibus.Lorem ipsum dolor sit amet, consectetur
            adipisicing elit. Lorem ipsum dolor sit amet.
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto
            possimus at a cum saepe molestias modi illo facere ducimus voluptatibus praesentium deleniti fugiat ab error
            quia sit perspiciatis velit necessitatibus.Lorem ipsum dolor sit amet, consectetur
            adipisicing elit. Lorem ipsum dolor sit amet.
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto
            possimus at a cum saepe molestias modi illo facere ducimus voluptatibus praesentium deleniti fugiat ab error
            quia sit perspiciatis velit necessitatibus.Lorem ipsum dolor sit amet, consectetur
            adipisicing elit. Lorem ipsum dolor sit amet.
          </p>
        </div>
      </div>
      <!-- Panel 2 -->
      <div>
        <input type="checkbox" name="panel" id="panel-2" class="hidden">
        <label for="panel-2" class="relative block bg-black text-white p-4 shadow border-b border-grey">Panel 2</label>
        <div class="accordion__content overflow-hidden bg-grey-lighter">
          <h2 class="accordion__header pt-4 pl-4">Header</h2>
          <p class="accordion__body p-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto possimus at a cum
            saepe molestias modi illo facere ducimus voluptatibus praesentium deleniti fugiat ab error quia sit
            perspiciatis velit necessitatibus.Lorem ipsum dolor sit amet, consectetur
            adipisicing elit. Lorem ipsum dolor sit amet.</p>
        </div>
      </div>
      <!--  Panel 3  -->
      <div>
        <input type="checkbox" name="panel" id="panel-3" class="hidden">
        <label for="panel-3" class="relative block bg-black text-white p-4 shadow border-b border-grey">Panel 3</label>
        <div class="accordion__content overflow-hidden bg-grey-lighter">
          <h2 class="accordion__header pt-4 pl-4">Header</h2>
          <p class="accordion__body p-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto possimus at a cum
            saepe molestias modi illo facere ducimus voluptatibus praesentium deleniti fugiat ab error quia sit
            perspiciatis velit necessitatibus.Lorem ipsum dolor sit amet, consectetur
            adipisicing elit. Lorem ipsum dolor sit amet.</p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
label:after {
  content: '+';
  position: absolute;
  right: 1em;
  color: #fff;
}

input:checked+label:after {
  content: '-';
  line-height: .8em;
}

.accordion__content {
  max-height: 0em;
  transition: all 0.4s cubic-bezier(0.865, 0.14, 0.095, 0.87);
}

input[name='panel']:checked~.accordion__content {
  /* Get this as close to what height you expect */
  max-height: 50em;
}
</style>
