<template>
  <div class="file-upload">
    <label :for="id" v-show="!started">
      <slot>
        Upload
      </slot>
      <input type="file" :id="id" @change="handleFile" :required="required">
      <!-- <input type="hidden" :name="name" :value="path"> -->
    </label>
    <div class="progress w-100" v-show="started && !success">
      <div :id="'progress-' + id" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%">
        <span v-if="percent >= 100 && !error">Processing...</span>
        <span v-else-if="!error" class="pl-3 text-left">{{percent}}%</span>
        <span v-else="">Error</span>
      </div>
    </div>
    <div class="text-danger status" v-show="error">
      <strong class="mr-2">Error:</strong>
      {{error}}
      <!-- <button type="button" @click="reset" class="font-weight-bold btn btn-link">Try again</button> -->
    </div>
    <div class="text-primary status success" v-show="success">
      <strong class="mr-2">Success:</strong> {{success}}
    </div>
  </div>
</template>

<script>
    export default {
        props: ["id", "name", "action", 'required', 'data'],
        data () {
          return {
            error: '',
            success: '',
            started: false,
            path: null,
            percent:0,
            clone: null,
          }
        },
        mounted() {
            console.log('File upload mounted.')
            this.clone = $('#' + this.id).val('').clone(true);
        },
        methods: {
          onUploadProgress (event) {
            var percent = Math.round( (event.loaded * 100) / event.total );
            $('#progress-' + this.id).width(percent + '%');
            this.percent = percent;
          },
          reset () {
            console.log('resetting fileupload');
            // this.$forceUpdate()
            this.started = false
            this.success = ''
            this.error = ''
            this.percent = 0
            this.path = null
            $('#progress-' + this.id).removeClass('bg-danger')
            $('#progress-' + this.id).width('0%');
            $('#' + this.id).replaceWith(this.clone);
          },
          handleFile () {
            console.log('handling file');
            var input = $('#' + this.id)[0];
            var data = new FormData();
            var config = {};
            config.onUploadProgress = this.onUploadProgress;
            for (var i = 0; i < this.data.length; i++) {
              var d = this.data[i]
              data.append(d.name, d.value);
            }
            for (var i = 0; i < input.files.length; i++) {
              var file = input.files[i]
              data.append(this.name + '-' + i, file);
            }
            this.started = true;
            axios.post(this.action, data, config).then(res => {
              this.success = 'File uploaded';
              this.error = '';
              this.$emit('success', res.data);
            }).catch(err => {
              // console.error(err);
              this.error = 'Invalid file extension or file is too big'
              $('#progress-' + this.id).addClass('bg-danger')
              this.success = ''
            })
          }
        }
    }
</script>

<style lang="css" scoped>
.file-upload {
  width: 100%;
  background: white;
  padding: 2rem;
  border: 1px dashed #aaa;
  border-radius: 0.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-wrap: wrap;
  position: relative;
}
.status {
  position: absolute;
  bottom: 4px;
  left: 0;
  text-align: center;
  width: 100%;
}
.status.success {
  position: relative;
  bottom: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}
label {
    padding: 0.3rem 1rem;
    margin: 0;
    border: 1px solid #03A9F4;
    border-radius: 0.3rem;
    color: #03A9F4;
    position: relative;
}

.progress, label, .success {
  height: 2.2rem;
}
label:hover {
    background-color: rgba(3, 169, 244, 0.08);
    cursor: pointer;
    color: #0498dc;
    border-color: #0498dc;
}

input {
  opacity: 0;
  position: absolute;
  width: 100%;
  top: 0;
  left: 0;
}
</style>
