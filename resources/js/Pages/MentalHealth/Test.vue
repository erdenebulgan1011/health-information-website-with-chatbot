<template>
  <AppLayout :title="category.name + ' Тест'">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ category.name }} Тест
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">{{ category.name }}</h3>
            <p class="text-gray-600">{{ category.description }}</p>
          </div>

          <form @submit.prevent="submitTest">
            <div class="space-y-8">
              <div 
                v-for="(question, index) in questions" 
                :key="question.id"
                class="p-4 border border-gray-200 rounded-md"
              >
                <div class="mb-3">
                  <span class="text-gray-500 text-sm">Асуулт {{ index + 1 }}/{{ questions.length }}</span>
                  <h4 class="font-medium">{{ question.question_text }}</h4>
                </div>

                <!-- Multiple Choice Question -->
                <div v-if="question.question_type === 'multiple_choice'">
                  <div 
                    v-for="option in JSON.parse(question.options)" 
                    :key="option.value"
                    class="mb-2"
                  >
                    <label class="inline-flex items-center">
                      <input 
                        type="radio" 
                        :name="'question_' + question.id" 
                        v-model="form.answers[question.id]" 
                        :value="option.value" 
                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        :required="question.is_required"
                      >
                      <span class="ml-2">{{ option.text }}</span>
                    </label>
                  </div>
                </div>

                <!-- Scale Question -->
                <div v-else-if="question.question_type === 'scale'" class="mt-4">
                  <div class="flex items-center">
                    <div class="w-full">
                      <input 
                        type="range" 
                        :name="'question_' + question.id" 
                        v-model.number="form.answers[question.id]" 
                        min="0" 
                        max="5" 
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                        :required="question.is_required"
                      >
                      <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>0</span>
                        <span>1</span>
                        <span>2</span>
                        <span>3</span>
                        <span>4</span>
                        <span>5</span>
                      </div>
                    </div>
                    <div class="ml-4 w-12 text-center">
                      {{ form.answers[question.id] || 0 }}
                    </div>
                  </div>
                </div>

                <!-- Boolean Question -->
                <div v-else-if="question.question_type === 'boolean'" class="mt-3">
                  <div class="flex space-x-4">
                    <label class="inline-flex items-center">
                      <input 
                        type="radio" 
                        :name="'question_' + question.id" 
                        v-model="form.answers[question.id]" 
                        value="true" 
                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        :required="question.is_required"
                      >
                      <span class="ml-2">Тийм</span>
                    </label>
                    <label class="inline-flex items-center">
                      <input 
                        type="radio" 
                        :name="'question_' + question.id" 
                        v-model="form.answers[question.id]" 
                        value="false" 
                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        :required="question.is_required"
                      >
                      <span class="ml-2">Үгүй</span>
                    </label>
                  </div>
                </div>

                <!-- Text Question -->
                <div v-else-if="question.question_type === 'text'" class="mt-3">
                  <textarea 
                    :name="'question_' + question.id" 
                    v-model="form.answers[question.id]" 
                    rows="3" 
                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :required="question.is_required"
                  ></textarea>
                </div>
              </div>
            </div>

            <div class="mt-8 flex justify-between">
              <Link 
                href="/mental-health" 
                class="py-2 px-4 bg-gray-500 hover:bg-gray-600 text-white rounded-md transition"
              >
                Буцах
              </Link>
              <div>
                <button
                  type="button"
                  @click="clearForm"
                  class="mr-3 py-2 px-4 bg-gray-200 hover:bg-gray-300 rounded-md transition"
                >
                  Цэвэрлэх
                </button>
                <button
      type="submit"
      class="py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition"
      :disabled="processing"
    >
      {{ processing ? 'Илгээж байна...' : 'Тестийг дуусгах' }}
    </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { defineComponent, reactive, ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/inertia-vue3';


export default defineComponent({
  components: {
    AppLayout,
    Link
  },
  
  props: {
    category: {
      type: Object,
      required: true
    },
    questions: {
      type: Array,
      required: true
    }
  },
  
  setup(props) {
    const processing = ref(false);
    
    // Initialize form with empty answers
    const form = useForm({
      answers: {}
    });
    
    // Submit the test
    const submitTest = () => {
      console.log('Submitting test to:', `/mental-health/process-test/submit/${props.category.slug}`);

      processing.value = true;
      form.post(`/mental-health/process-test/submit/${props.category.slug}`, {
        onFinish: () => {
          processing.value = false;
        }
      });
    };
    
    // Clear form data
    const clearForm = () => {
      form.answers = {};
    };
    
    return {
      form,
      processing,
      submitTest,
      clearForm
    };
  }
});
</script>