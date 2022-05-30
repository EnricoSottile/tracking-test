@extends('layouts.master')

@section('main_content')

      <!-- development only - this is a tiny and optimized vue version designed to be used from a CDN  -->
      <!-- In a real case I go for the full build step with webpack, babel, npm... -->
      <script type="module">
        import { createApp } from 'https://unpkg.com/petite-vue?module'

        createApp({
          // exposed to all expressions
          uri: "{{ route('tracking.show')}}",
          tracking_code: '',
          tracking: {},
          preventAjax: false,


          async onSubmitClick(){
            if (!this.tracking_code.length) {
              alert('please input a tracking code');
              return;
            }

            this.preventAjax = true;
            const url = `${this.uri}/${this.tracking_code}`;
            // const url = `http://httpstat.us/500`;

            const response = await fetch(url);
            if (!response.ok) {
              const msg = `HTTP error! status: ${response.status}`;
              this.tracking.message = msg;
              throw new Error(msg);
            }
            const data = await response.json();
            this.preventAjax = false;
          }

        }).mount()

      </script>


      <div v-scope class="block p-6 max-w-2xl bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 mx-auto">
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="name">Enter tracking code:
            </label>
            <input placeholder="Enter tracking code" v-model="tracking_code"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                type="text" name="tracking_code" id="tracking_code" required>
        </div>
        <div class="mb-6">
            <button type="submit" @click="onSubmitClick" :disabled="preventAjax"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </div>
        <div class="mb-6">
          <p v-if="tracking.message" v-text="tracking.message"></p>
        </div>
      </div>

@endsection
