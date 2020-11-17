<template>

    <!-- ------------------------------------------------------------------------------ -->   
    <!-- class="d-flex"   takes away spaces between objects -->
    <!-- -->
    <div class="d-flex">    
        <!-- <i class=""><i>   this is how you call a font awesome component -->
        <!-- -->

        <!-- --------------------------------------------------------------------- -->   
        <!-- Here we are iterating over the number in the fullStars() method -->
        <!-- v-on:click   is the full vesion of the short hand   @click      -->
        <!-- -->
        <!-- v-on:click="$emit('rating:changed', star)"   changed to         -->
        <!-- v-on:click="$emit('input', star)"   in order to use v-model     -->
        <!-- -->
        <i   
            class="fas fa-star" 
            v-for="star in fullStars" 
            v-bind:key="'full' + star" 
            v-on:click="$emit('input', star)"  
        ></i>
        <!-- --------------------------------------------------------------------- -->   
        
        <i class="fas fa-star-half-alt" v-if="halfStar"></i>                                <!-- This works because if we display a half star we do it only once -->
        
        <!-- --------------------------------------------------------------------- -->   
        <!-- Here we are iterating over the number in the emptyStars() method  -->
        <!-- v-on:click   is the full vesion of the short hand   @click        -->
        <!-- -->
        <!-- v-on:click="$emit('rating:changed', fullStars + star)" changed to -->
        <!-- v-on:click="$emit('input', fullStars + star)"   to use v-model    -->
        <!-- -->
        <i 
            class="far fa-star" 
            v-for="star in emptyStars" 
            v-bind:key="'empty' + star"
            v-on:click="$emit('input', fullStars + star)"
        ></i>
        <!-- --------------------------------------------------------------------- -->   
    </div>
    <!-- ------------------------------------------------------------------------------ -->  
</template>


<script>
export default {
    props: {
        //---------------------------------------------------------------------------------
        //  Commented out as we changed to using v-model 
        //  which needs the prop name to be   value   in order ro function
        //
        //  rating: Number  //  This is what we pass to this component

        value: Number       //  This is what we pass to this component
        //---------------------------------------------------------------------------------
    },

    //  Prop   rating   in star functions changed to   value   in order to use v-model   
    //
    computed: {         //  Computed Properties is used to calculate how many stars we need to display
        halfStar() {
        const fraction = Math.round((this.value - Math.floor(this.value)) * 100);
        
        // console.log(fraction);

        return fraction > 0 && fraction < 50;
        },
        fullStars() {
            //  return 3;

            // > 4.5 = 5 stars or 4.3 = 4 and half
            //
            return Math.round(this.value);
        },
        emptyStars() {
            //  return 1;

            // if rating would be 1.9, ceil(1.9) = 2, 5 - 2 = 3, render 3 empty stars
            //
            return 5 - Math.ceil(this.value);
        }
    },
    // created() {
    //   const numbers = [0.9, 4.0, 4.4, 4.5, 4.6, 4.9];

    //   numbers.forEach(n => {
    //     console.log(`round for ${n} is ${Math.round(n)}`);
    //     console.log(`floor for ${n} is ${Math.floor(n)}`);
    //     console.log(`ceil for ${n} is ${Math.ceil(n)}`);
    //     console.log("==================================");
    //   });
    // }
};
</script>