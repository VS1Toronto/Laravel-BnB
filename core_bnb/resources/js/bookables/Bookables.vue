<template>
  <div>
    <div v-if="loading">Data is loading...</div>
    <div v-else>
      <div class="row mb-4" v-for="row in rows" :key="'row' + row">
        <div
          class="col d-flex align-items-stretch"
          v-for="(bookable, column) in bookablesInRow(row)"
          :key="'row' + row + column"
        >
          <!-- --------------------------------------------------------------------------------------------- -->
          <!-- Commented Out and replaced with   <bookable-list-item v-bind="bookable"></bookable-list-item> -->
          <!-- -->
          <!-- <bookable-list-item
            v-bind:title="bookable.title"
            v-bind:description="bookable.description"
            V-bind:id="bookable.id"
          ></bookable-list-item> -->
          <!-- --------------------------------------------------------------------------------------------- -->

          <bookable-list-item v-bind="bookable"></bookable-list-item>
        </div>

        <div class="col" v-for="p in placeholdersInRow(row)" :key="'placeholder' + row + p"></div>
      </div>
    </div>
  </div>
</template>

<script>
import BookableListItem from "./BookableListItem";

export default {
  components: {
    BookableListItem
  },
  data() {
    return {
      bookables: null,
      loading: false,
      columns: 3
    };
  },
  computed: {
    rows() {
      return this.bookables === null
        ? 0
        : Math.ceil(this.bookables.length / this.columns);
    }
  },
  methods: {
    bookablesInRow(row) {
      return this.bookables.slice((row - 1) * this.columns, row * this.columns);
    },
    placeholdersInRow(row) {
      return this.columns - this.bookablesInRow(row).length;
    }
  },
  created() {
  this.loading = true;


  //------------------------------------------------------------------------------------------------------
  //  Example of promise left for reference
  //
  // const promise = new Promise((resolve, reject) => {
  //   console.log(resolve);
  //   console.log(reject);
  //   setTimeout(() => resolve("Hello"), 3000);
  // })
  //   .then(result => "Hello again " + result)
  //   .then(result => console.log(result))
  //   .catch(result => console.log(`Error ${result}`));
  // console.log(promise);
  //------------------------------------------------------------------------------------------------------


  const request = axios.get("http://leedavidsoncontentmanagementsystem1.com/CodeLaravel7/public/api/bookables").then(response => {
    this.bookables = response.data.data;    // Using resources nests properties so .data.data needed here
    this.loading = false;
  });

  //------------------------------------------------------------------------------------------------------
  //  SetTimeout sets initial data
  //
  //  Commented out to observe other code and its effect
  //
  // setTimeout(() => {
  //   this.bookables = [
  //     {
  //       title: 'Cheap Villa !!!',
  //       content: 'A very cheap villa'
  //     },
  //     {
  //       title: 'Cheap Villa 2',
  //       content: 'A very cheap villa 2'
  //     },
  //     {
  //       title: 'Cheap Villa 3',
  //       content: 'A very cheap villa 3'
  //     },
  //     {
  //       title: 'Cheap Villa 4',
  //       content: 'A very cheap villa 4'
  //     },
  //     {
  //       title: 'Cheap Villa 5',
  //       content: 'A very cheap villa 5'
  //     },
  //     {
  //       title: 'Cheap Villa 6',
  //       content: 'A very cheap villa 6'
  //     },
  //     {
  //       title: 'Cheap Villa 7',
  //       content: 'A very cheap villa 7'
  //     }
  //   ];
  //     this.loading = false;
  //   }, 2000);
  //------------------------------------------------------------------------------------------------------


  }
};
</script>