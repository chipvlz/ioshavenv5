<template>
  <div>
    <div id="toolbar-container" class="bg-light">

      <span class="ql-formats">
        <select class="ql-size"></select>
      </span>

      <span class="ql-formats">
        <select class="ql-align"></select>
      </span>

      <span class="ql-formats">
        <button class="ql-bold"></button>
        <button class="ql-italic"></button>
        <button class="ql-underline"></button>
      </span>

      <span class="ql-formats">
        <button class="ql-header" value="1"></button>
        <button class="ql-header" value="2"></button>
        <button class="ql-blockquote"></button>
        <button class="ql-code-block"></button>
      </span>

      <span class="ql-formats">
        <button class="ql-list" value="ordered"></button>
        <button class="ql-list" value="bullet"></button>
      </span>

      <span class="ql-formats">
        <button class="ql-link"></button>
        <button class="ql-image"></button>
        <button class="ql-video"></button>
      </span>

      <span class="ql-formats">
        <button class="ql-clean"></button>
      </span>
    </div>
    <div id="app-description" class="bg-white">

      <slot>
        <p>Insert an app description</p>
      </slot>
    </div>
  </div>

</template>

<script>
    export default {
        data () {
          return {
            quill: {}
          }
        },
        mounted() {
            console.log('Editor mounted.')
            this.quill = new Quill('#app-description', {
              modules: {
                toolbar: '#toolbar-container'
              },
              theme: 'snow'
            });

            $('#app-description-value').val(this.quill.root.innerHTML);

            this.quill.on('text-change', (delta, oldDelta, source) => {
              $('#app-description-value').val(this.quill.root.innerHTML);
            });
        }
    }
</script>
