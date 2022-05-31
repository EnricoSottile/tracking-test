@extends('layouts.master')

@section('main_content')

      <!-- development only - this is a tiny and optimized vue version designed to be used from a CDN.
           In a real case I often go for the full build step with webpack, babel, npm...
           My favourite app structure usually involves single file components that can be reused and easily tested.
           But there are websites that just need some "enhancement" and not a full frontend framework.      
          -->
      <script type="module">
        import { createApp } from 'https://unpkg.com/petite-vue?module'

        createApp({
          tracking_code: '',
          tracking: {},
          preventAjax: false,


          async onSubmit(e){
            if (!this.tracking_code.length) {
              alert('please input a tracking code');
              return;
            }

            this.preventAjax = true;

            // using the query parameter "?=1234" instead of a segment such as "/tracking/1234" 
            // allows to support javascript disabled browsers so that submitting the form always works
            const url = `${e.target.action}/?tracking_code=${this.tracking_code}`;

            // we are not modifiying anything on the server, so GET is the correct HTTP verb
            const response = await fetch(url, {
              headers: {
                'Content-Type': 'application/json',

                // in older Laravel version I used to manually add the XSRF token
                // but I see it's already in the request, I can only guess that's a Sail feature
                // or an automation by Vue. Please forgive my ignorance on this fact: 
                // I've not used Laravel for a few years and I need to catch up on a few things

                // trick to have laravel recognize the request as ajax
                // when doing $request->ajax() 
                'X-Requested-With' : 'XMLHttpRequest'
              },
            });

            // a very basic error handling
            // in a real world case I usually extract all the common error handling boilerplate
            // to an external file, so that the actual request remain tidy and clean
            if (!response.ok) this.handleError(response);
            const data = await response.json();
            
            this.tracking = data;
            this.preventAjax = false; // restore the button
          },

          handleError(response){
            let msg = `HTTP error! status: ${response.status}.`;
            
            if (response.status === 404) msg += ' The tracking code does not exist!' 
            this.tracking.error = msg;
            this.preventAjax = false; // restore the button
            throw new Error(msg);
          }
          formatDate(datetime){
            let dateObject = new Date(Date.parse( datetime ))
            return dateObject.toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric"}) ;
          }
        }).mount()

      </script>


      <!-- using a form allows for a better user experience overall even when sending data via ajax requests
           eg: automatic handling of keyboard events, required inputs and so on -->
      <form action="{{ route('tracking.show')}}" @submit.prevent="onSubmit" method="get" v-scope class="block p-6 max-w-2xl bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 mx-auto">
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="name">Enter tracking code:
            </label>
            <input placeholder="Enter tracking code" v-model="tracking_code"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                type="text" name="tracking_code" id="tracking_code" required>
        </div>
        <div class="mb-6">
            <button type="submit" :disabled="preventAjax"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </div>
        <div class="mb-6">
          <p v-if="tracking.error" v-text="tracking.error"></p>

          <p v-if="tracking.estimated_delivery">
            <template v-if="new Date(Date.parse( tracking.estimated_delivery )) < new Date()">The shipping has arrived on</template> 
            <template v-else>The shipping will arrive on</template> 
            @{{ formatDate(tracking.estimated_delivery)}}
          </p>
        </div>
      </form>

@endsection
