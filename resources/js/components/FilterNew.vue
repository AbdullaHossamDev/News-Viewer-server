<template>
  <!-- <div>
    <b-form-checkbox
      id="checkbox-1"
      v-model="status"
      name="checkbox-1"
      value="accepted"
      unchecked-value="not_accepted"
    >
      I accept the terms and use
    </b-form-checkbox>

    <div>
      State: <strong>{{ status }}</strong>
    </div>
  </div> -->

  <div class="card rightDiv">
    <div class="card-header h4">Filter<i class="fa fa-filter"></i></div>
    <ul class="list-group p-0">
      <li class="list-group-item">
        <h3 class="card-title">Countries</h3>
        <input
          type="checkbox"
          id="egypt"
          name="egypt"
          value="EG"
          class="m-2"
          v-model="status"
        />
        <label for="egypt">Egypt</label><br />
        <input
          type="checkbox"
          id="uae"
          name="uae"
          value="UAE"
          class="m-2"
          v-model="status"
        />
        <label for="uae">United Arab Emirates</label><br />
      </li>
      <li class="list-group-item">
        <h3 class="card-title">Categories</h3>
        <input
          type="checkbox"
          id="business"
          name="business"
          value="Business"
          class="m-2"
          v-model="status"
        />
        <label for="business">Business</label><br />
        <input
          type="checkbox"
          id="sports"
          name="sports"
          value="Sports"
          class="m-2"
          v-model="status"
        />
        <label for="sports">Sports</label><br />
      </li>
      <!-- <li class="list-group-item">
        <input type="submit" class="btn btn-light" value="Filter" />
      </li> -->
    </ul>
  </div>
</template>
<script>
export default {
  name: "Filter",
  data() {
    return {
      status: []
    };
  },
  watch: {
    status: {
      immediate: true,
      handler(newVal) {
        let filteredData = {};
        for (let f of newVal) {
          filteredData[f] = true;
        }
        this.$emit("filterNew", filteredData);
      }
    }
  }
};
</script>

<style scoped>
.rightDiv {
  position: absolute;
  top: 10%;
  left: 10%;
  width: 67%;
  height: 200px;
}
</style>
