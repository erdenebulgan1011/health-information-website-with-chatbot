<template>
  <AppLayout title="Сэтгэл Зүйн Тестүүд">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Сэтгэл Зүйн Тестүүд
      </h2>
    </template>
    
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <h3 class="text-lg font-semibold mb-4">Өөрийн сэтгэл зүйн байдлыг үнэлээрэй</h3>
          <p class="mb-6">
            Дараах тестүүдийг хийснээр өөрийн сэтгэл зүйн эрүүл мэнд болон 
            хувь хүний сайн сайхан байдлын талаар илүү ойлголттой болно.
          </p>
          
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
              v-for="category in categories"
              :key="category.id"
              class="bg-gray-50 p-5 rounded-lg shadow hover:shadow-md transition-shadow"
            >
              <div class="flex items-center gap-3 mb-3">
                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-600">
                  <i :class="category.icon || 'fas fa-brain'" class="text-xl"></i>
                </div>
                <h4 class="text-lg font-medium">{{ category.name }}</h4>
              </div>
              <p class="text-gray-600 mb-4">{{ category.description }}</p>
              <Link :href="`/mental-health/tests/${category.slug}`" class="block w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white text-center rounded-md transition">
  Тестийг үргэлжлүүлэх
</Link>

            </div>
          </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
          <h3 class="text-lg font-semibold mb-4">Өмнөх Тестүүд</h3>
          <p class="mb-4">
            Өөрийн өмнө хийсэн тестүүдийн үр дүнг харах болон өөр хоорондоо харьцуулах.
          </p>
          <Link
            href="/mental-health/history"
            class="inline-block py-2 px-4 bg-gray-700 hover:bg-gray-800 text-white rounded-md transition"
          >
            Миний түүх харах
          </Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { defineComponent } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';

export default defineComponent({
  components: {
    AppLayout,
    Link
  },
  
  props: {
    categories: {
      type: Array,
      required: true
    }
  },
  setup() {
    return {};
  }
});
</script>