<template>
    <AppLayout title="Тестийн Үр Дүн">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Тестийн Үр Дүн
        </h2>
      </template>
  
      <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
          <!-- Result Summary Card -->
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">
              {{ session.testCategory.name }} Тестийн Үр Дүн
            </h3>
            
            <div class="flex items-center p-4 my-4 rounded-lg" :class="getResultBackgroundColor()">
              <div class="mr-4">
                <div class="w-16 h-16 rounded-full flex items-center justify-center bg-white">
                  <span class="text-2xl font-bold">{{ results.total_score }}</span>
                </div>
              </div>
              <div>
                <h4 class="text-lg font-medium">{{ getResultLevelText() }}</h4>
                <p>{{ getResultDescription() }}</p>
              </div>
            </div>
            
            <!-- Depression specific info -->
            <div v-if="hasSeverity()" class="mt-4">
              <h4 class="font-medium mb-2">Сэтгэл гутралын түвшин:</h4>
              <p>{{ getSeverityText() }}</p>
              
              <div v-if="results.risk_factors && results.risk_factors.length > 0" class="mt-4">
                <h5 class="font-medium mb-1">Илрүүлсэн эрсдэлийн хүчин зүйлс:</h5>
                <ul class="list-disc pl-5">
                  <li v-for="factor in results.risk_factors" :key="factor" class="mt-1">
                    {{ getRiskFactorText(factor) }}
                  </li>
                </ul>
              </div>
            </div>
            
            <!-- Stress specific info -->
            <div v-if="hasLevel() && results.areas" class="mt-4">
              <h4 class="font-medium mb-2">Стрессийн түвшин:</h4>
              <p>{{ getLevelText() }}</p>
              
              <div v-if="results.areas && results.areas.length > 0" class="mt-4">
                <h5 class="font-medium mb-1">Стрессийн гол талбарууд:</h5>
                <ul class="list-disc pl-5">
                  <li v-for="area in results.areas" :key="area" class="mt-1">
                    {{ getAreaText(area) }}
                  </li>
                </ul>
              </div>
            </div>
            
            <!-- Anxiety specific info -->
            <div v-if="hasLevel() && results.triggers" class="mt-4">
              <h4 class="font-medium mb-2">Түгшүүрийн түвшин:</h4>
              <p>{{ getLevelText() }}</p>
              
              <div v-if="results.triggers && results.triggers.length > 0" class="mt-4">
                <h5 class="font-medium mb-1">Илрүүлсэн түгшүүрийн шалтгаанууд:</h5>
                <ul class="list-disc pl-5">
                  <li v-for="trigger in results.triggers" :key="trigger" class="mt-1">
                    {{ getTriggerText(trigger) }}
                  </li>
                </ul>
              </div>
            </div>
            
            <!-- Sleep specific info -->
            <div v-if="hasQuality()" class="mt-4">
              <h4 class="font-medium mb-2">Нойрны чанар:</h4>
              <p>{{ getQualityText() }}</p>
              
              <div v-if="results.issues && results.issues.length > 0" class="mt-4">
                <h5 class="font-medium mb-1">Илрүүлсэн нойрны асуудлууд:</h5>
                <ul class="list-disc pl-5">
                  <li v-for="issue in results.issues" :key="issue" class="mt-1">
                    {{ getSleepIssueText(issue) }}
                  </li>
                </ul>
              </div>
            </div>
          </div>
          
          <!-- Recommendations Card -->
          <div v-if="recommendations.length > 0" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Зөвлөмжүүд</h3>
            
            <div v-for="(recommendation, index) in recommendations" :key="recommendation.id" 
                 class="p-4 rounded-lg mb-4" :class="getSeverityColor(recommendation.severity_level)">
              <h4 class="font-medium">Зөвлөмж {{ index + 1 }}</h4>
              <p class="my-2">{{ recommendation.recommendation_text }}</p>
              
              <div v-if="recommendation.action_steps" class="mt-3">
                <h5 class="font-medium mb-1">Авах арга хэмжээнүүд:</h5>
                <p>{{ recommendation.action_steps }}</p>
              </div>
            </div>
          </div>
          
          <!-- Resources Card -->
          <div v-if="resources.length > 0" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Нэмэлт материалууд</h3>
            
            <div v-for="resource in resources" :key="resource.id" class="p-4 border border-gray-200 rounded-lg mb-4">
              <div class="flex justify-between">
                <h4 class="font-medium">{{ resource.title }}</h4>
                <span v-if="resource.is_premium" class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded">Премиум</span>
              </div>
              
              <p class="my-2 text-gray-600">{{ resource.description }}</p>
              
              <div class="flex justify-between items-center mt-3">
                <div class="flex flex-wrap gap-2">
                  <span v-for="tag in JSON.parse(resource.tags)" :key="tag" 
                        class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">
                    {{ tag }}
                  </span>
                </div>
                
                <a v-if="resource.url" :href="resource.url" target="_blank" 
                   class="py-1 px-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition text-sm">
                  Үзэх
                </a>
              </div>
            </div>
          </div>
          
          <!-- History Chart Card -->
          <div v-if="historyData.length > 1" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Таны явц</h3>
            
            <div class="h-64">
              <LineChart :chart-data="historyChartData" :options="chartOptions" />
            </div>
            
            <div class="mt-4 text-center">
              <Link 
                :href="route('mental-health.history')" 
                class="inline-block py-2 px-4 bg-gray-700 hover:bg-gray-800 text-white rounded-md transition"
              >
                Бүх түүхийг харах
              </Link>
            </div>
          </div>
          
          <div class="flex justify-between mt-6">
            <Link 
              :href="route('mental-health.index')" 
              class="py-2 px-4 bg-gray-500 hover:bg-gray-600 text-white rounded-md transition"
            >
              Буцах
            </Link>
            <Link 
              :href="route('mental-health.show-test', session.testCategory.slug)" 
              class="py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition"
            >
              Тестийг дахин авах
            </Link>
          </div>
        </div>
      </div>
    </AppLayout>
  </template>
  
  <script>
  import { defineComponent, computed } from 'vue';
  import AppLayout from '@/Layouts/AppLayout.vue';
  import { Link } from '@inertiajs/inertia-vue3';
  import { Line as LineChart } from 'vue-chartjs';
  import { Chart as ChartJS, CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend } from 'chart.js';
  
  // Register ChartJS components
  ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend);
  
  export default defineComponent({
    components: {
      AppLayout,
      Link,
      LineChart
    },
    
    props: {
      session: {
        type: Object,
        required: true
      },
      results: {
        type: Object,
        required: true
      },
      recommendations: {
        type: Array,
        required: true
      },
      resources: {
        type: Array,
        required: true
      },
      historyData: {
        type: Array,
        required: true
      }
    },
    
    setup(props) {
      // Helper functions to check result type
      const hasLevel = () => 'level' in props.results;
      const hasSeverity = () => 'severity' in props.results;
      const hasQuality = () => 'quality' in props.results;
      
      // Background color based on result
      const getResultBackgroundColor = () => {
        if (hasLevel()) {
          const level = props.results.level;
          if (level === 'low') return 'bg-green-100 text-green-800';
          if (level === 'moderate') return 'bg-yellow-100 text-yellow-800';
          if (level === 'high') return 'bg-orange-100 text-orange-800';
          if (level === 'severe') return 'bg-red-100 text-red-800';
        }
        
        if (hasSeverity()) {
          const severity = props.results.severity;
          if (severity === 'minimal') return 'bg-green-100 text-green-800';
          if (severity === 'mild') return 'bg-blue-100 text-blue-800';
          if (severity === 'moderate') return 'bg-yellow-100 text-yellow-800';
          if (severity === 'moderately_severe') return 'bg-orange-100 text-orange-800';
          if (severity === 'severe') return 'bg-red-100 text-red-800';
        }
        
        if (hasQuality()) {
          const quality = props.results.quality;
          if (quality === 'good') return 'bg-green-100 text-green-800';
          if (quality === 'fair') return 'bg-blue-100 text-blue-800';
          if (quality === 'poor') return 'bg-yellow-100 text-yellow-800';
          if (quality === 'very_poor') return 'bg-red-100 text-red-800';
        }
        
        return 'bg-gray-100 text-gray-800';
      };
      
      // Result level text
      const getResultLevelText = () => {
        if (hasLevel()) {
          const level = props.results.level;
          if (level === 'low') return 'Бага зэргийн түвшин';
          if (level === 'moderate') return 'Дунд зэргийн түвшин';
          if (level === 'high') return 'Өндөр түвшин';
          if (level === 'severe') return 'Маш өндөр түвшин';
        }
        
        if (hasSeverity()) {
          const severity = props.results.severity;
          if (severity === 'minimal') return 'Бага зэргийн';
          if (severity === 'mild') return 'Зөөлөн';
          if (severity === 'moderate') return 'Дунд зэрэг';
          if (severity === 'moderately_severe') return 'Дунд зэргээс хүнд';
          if (severity === 'severe') return 'Хүнд';
        }
        
        if (hasQuality()) {
          const quality = props.results.quality;
          if (quality === 'good') return 'Сайн';
          if (quality === 'fair') return 'Дунд зэрэг';
          if (quality === 'poor') return 'Муу';
          if (quality === 'very_poor') return 'Маш муу';
        }
        
        return 'Үр дүн';
      };
      
      // Result description
      const getResultDescription = () => {
        if (hasLevel()) {
          const level = props.results.level;
          if (level === 'low') return 'Таны стрессийн түвшин бага байна.';
          if (level === 'moderate') return 'Таны стрессийн түвшин дунд зэргийн байна.';
          if (level === 'high') return 'Таны стрессийн түвшин өндөр байна.';
          if (level === 'severe') return 'Таны стрессийн түвшин маш өндөр байна.';
        }
        
        if (hasSeverity()) {
          const severity = props.results.severity;
          if (severity === 'minimal') return 'Таны сэтгэл гутралын шинж тэмдэг бага зэрэг байна.';
          if (severity === 'mild') return 'Таны сэтгэл гутралын шинж тэмдэг зөөлөн байна.';
          if (severity === 'moderate') return 'Таны сэтгэл гутралын шинж тэмдэг дунд зэрэг байна.';
          if (severity === 'moderately_severe') return 'Таны сэтгэл гутралын шинж тэмдэг дунд зэргээс хүнд байна.';
          if (severity === 'severe') return 'Таны сэтгэл гутралын шинж тэмдэг хүнд байна.';
        }
        
        if (hasQuality()) {
          const quality = props.results.quality;
          if (quality === 'good') return 'Таны нойрны чанар сайн байна.';
          if (quality === 'fair') return 'Таны нойрны чанар дунд зэрэг байна.';
          if (quality === 'poor') return 'Таны нойрны чанар муу байна.';
          if (quality === 'very_poor') return 'Таны нойрны чанар маш муу байна.';
        }
        
        return 'Тестийн нийт оноо: ' + props.results.total_score;
      };
      
      // Helper to get translated level text
      const getLevelText = () => {
        const level = props.results.level;
        if (level === 'low') return 'Бага зэрэг';
        if (level === 'moderate') return 'Дунд зэрэг';
        if (level === 'high') return 'Өндөр';
        if (level === 'severe') return 'Маш өндөр';
        return level;
      };
      
      // Helper to get translated severity text
      const getSeverityText = () => {
        const severity = props.results.severity;
        if (severity === 'minimal') return 'Бага зэрэг';
        if (severity === 'mild') return 'Зөөлөн';
        if (severity === 'moderate') return 'Дунд зэрэг';
        if (severity === 'moderately_severe') return 'Дунд зэргээс хүнд';
        if (severity === 'severe') return 'Хүнд';
        return severity;
      };
      
      // Helper to get translated quality text
      const getQualityText = () => {
        const quality = props.results.quality;
        if (quality === 'good') return 'Сайн';
        if (quality === 'fair') return 'Дунд зэрэг';
        if (quality === 'poor') return 'Муу';
        if (quality === 'very_poor') return 'Маш муу';
        return quality;
      };
      
      // Helper to get area descriptions
      const getAreaText = (area) => {
        if (area === 'work') return 'Ажлын стресс';
        if (area === 'relationships') return 'Харилцааны стресс';
        if (area === 'financial') return 'Санхүүгийн стресс';
        if (area === 'health') return 'Эрүүл мэндийн стресс';
        return area;
      };
      
      // Helper to get risk factor descriptions
      const getRiskFactorText = (factor) => {
        if (factor === 'suicidal_ideation') return 'Амиа хорлох бодол (Яаралтай тусламж авах хэрэгтэй)';
        if (factor === 'appetite_changes') return 'Хоолны дуршил өөрчлөгдсөн';
        if (factor === 'sleep_disturbance') return 'Нойрны хямрал';
        if (factor === 'fatigue') return 'Ядаргаа, эрч хүчгүй байдал';
        return factor;
      };
      
      // Helper to get anxiety trigger descriptions
      const getTriggerText = (trigger) => {
        if (trigger === 'social') return 'Нийгмийн харилцаа';
        if (trigger === 'health') return 'Нийгмийн харилцаа';
      };

    
    
    getSeverityColor  = (severity)=> {
      // Return color class based on severity level
      if (score < 5) return 'green';
  else if (score < 10) return 'orange';
  else return 'red';
    };
  }
}
);


</script>