<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gain Task</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" integrity="sha512-WWc9iSr5tHo+AliwUnAQN1RfGK9AnpiOFbmboA0A0VJeooe69YR2rLgHw13KxF1bOSLmke+SNnLWxmZd8RTESQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container my-2">
        <div id="app">
            <form @submit.prevent="submitForm">
                <div class="row justify-content-center mb-2">
                    <div class="col-lg-2">
                        <label for="name">{{ __('Segment Name') }} *</label>
                    </div>

                    <div class="col-lg-10">
                        <input type="text" v-model="form.segment_name" class="form-control" id="name" placeholder="{{ __('Enter Name') }}">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-2">
                        <label for="name">{{ __('Segment Logic') }} *</label>
                    </div>

                    <div class="col-lg-2">
                        <select v-model="form.segment_logic_type" class="form-control">
                            <option value="first_name">First name</option>
                            <option value="last_name">Last name</option>
                            <option value="email">Email</option>
                            <option value="birth_day">Birth day</option>
                            <option value="created_at">Created at</option>
                        </select>
                    </div>

                    <div class="col-lg-2">
                        <select v-model="form.date_type" class="form-control" v-if="form.segment_logic_type === 'created_at' ">
                            <option  v-for="dateType in dateTypeFields" :value="dateType">@{{ dateType }}</option>
                        </select>

                        <select v-model="form.text_type" class="form-control" v-else>
                            <option  v-for="textType in textTypeFields" :value="textType">@{{ textType }}</option>
                        </select>
                    </div>

                    <div class="col-lg-2">
                        <input type="text" v-model="form.date" class="form-control" id="input_date" placeholder="{{ __('Enter Date') }}"  v-if="form.segment_logic_type === 'created_at' ">
                        <input type="text" v-model="form.word" class="form-control" id="" placeholder="{{ __('Enter word') }}" v-else>
                    </div>
                </div>

                <div class="row d-flex justify-content-start">
                    <button type="submit" class="btn btn-primary mr-2">Save</button>
                    <button type="button" class="btn btn-dark">Cancel</button>
                </div>
            </form>

            <div>
            </div>

        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js" integrity="..." crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js" integrity="..." crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.5/axios.min.js" integrity="sha512-TjBzDQIDnc6pWyeM1bhMnDxtWH0QpOXMcVooglXrali/Tj7W569/wd4E8EDjk1CwOAOPSJon1VfcEt1BI4xIrA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

    <script>
        let dateToday = new Date();
        let dates =  $( "#input_date" ).datetimepicker({
        format:'Y-m-d H:i:s',
        minDate:dateToday,
        });
    </script>

    <script>
        const { createApp, ref } = Vue

        createApp({
          setup() {
            const name = ref('Imtiaz ahmed afzal')
            const dateTypeFields = ref(['before', 'on', 'after', 'on or before', 'on or after', 'between']);
            const textTypeFields = ref(['is', 'is_not', 'starts_with', 'ends_with', 'contains', 'doesnot_starts_with', 'doesnot_end_with', 'doesnot_contains']);
            const form = ref({
                'segment_name': '',
                'segment_logic_type': '',
                'date_type': '',
                'text_type': '',
                'date': '',
                'word': '',

            });

            const result = ref('');
            const isResult = ref(false);

            const submitForm = () => {
                axios.post('/submit-form', form.value)
                .then(response => {
                    isResult.value = true;
                    result.value = response.data.exists;

                    console.log(response.data.exists);
                })
                .catch(error => {
                    isResult.value = false;
                    console.error(error.response.data);
                });

                console.log('Form submitted:', form);
            }

            return {
              name,
              dateTypeFields,
              textTypeFields,
              form,
              submitForm
            }

          }
        }).mount('#app')
      </script>
</body>
</html>
