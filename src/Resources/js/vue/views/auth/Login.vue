<template>
  <v-container>
      <v-row align="center" justify="center" >
          <v-col cols="12" sm="10">
            <v-card class="elevation-6 mt-10"  >
             <v-window v-model="step">
                <v-window-item :value="1">
                  <v-row>
                    <v-col cols="12" md="6">
                      <v-card-text class="mt-12">
                        <h4
                          class="text-center"
                        >Login in to Your Account</h4>
                        <h6
                          class="text-center  grey--text "
                        >Log in to your account so you can continue builiding <br>and editing your onboarding flows</h6>
                        <v-row align="center" justify="center">
                          <v-col cols="12" sm="8">
                           <v-alert
                            v-if="error"
                            border="top"
                            color="red lighten-2"
                            type="error"
                            :class="{'mt-16':error}"
                            dark
                          >
                            {{error}}
                          </v-alert>
                          <v-text-field
                            label="Email"
                            v-model="form.email"
                            outlined
                            dense
                            color="blue"
                            autocomplete="false"
                            :class="{'mt-16':!error}"
                          />
                          <v-text-field
                            label="Password"
                            v-model="form.password"
                            @keyup.enter="login(form)"
                            outlined
                            dense
                            color="blue"
                          autocomplete="false"
                           type="password"
                          
                          />
                            <v-row>
                              <v-col cols="12" sm="7">
                                <v-checkbox
                                  label="Remember Me"
                                  class="mt-n1"
                                  color="blue"
                                ></v-checkbox>
                              </v-col>
                              <v-col cols="12" sm="5">
                                <span class="caption blue--text">Forgot password</span>
                              </v-col>
                            </v-row>
                          <v-btn color="blue" dark block tile :loading="loading" @click="login(form)">Log in</v-btn>
                     
                         <h5
                          class="text-center  grey--text mt-4 mb-3"
                        >Or Log in using</h5>
                         <div class="d-flex  justify-space-between align-center mx-10 mb-16">
                        <v-btn depressed outlined color="grey">
                          <v-icon color="red">fab fa-google</v-icon>
                        </v-btn>
                        <v-btn depressed outlined color="grey">
                          <v-icon color="blue">fab fa-facebook-f</v-icon>
                        </v-btn>
                        <v-btn depressed outlined color="grey">
                          <v-icon color="light-blue lighten-3">fab fa-twitter</v-icon>
                        </v-btn>
                         </div>
                          </v-col>
                        </v-row>  
                      </v-card-text>
                    </v-col>
                    <v-col cols="12" md="6" class="blue rounded-bl-xl" >
                    <div style="  text-align: center; padding: 180px 0;">
                      <v-card-text class="white--text" >
                        <h3 class="text-center ">Don't Have an Account Yet?</h3>
                        <h6
                          class="text-center"
                        >Let's get you all set up so you can start creating your your first<br>  onboarding experience</h6>
                      </v-card-text>
                      <div class="text-center">
                        <v-btn tile outlined dark @click="step++">SIGN UP</v-btn>
                      </div>
                      </div>
                    </v-col>
                  </v-row>
                </v-window-item>
                <v-window-item :value="2">
                  <v-row >
                    <v-col cols="12" md="6" class="blue rounded-br-xl">
                     <div style="  text-align: center; padding: 180px 0;">
                      <v-card-text class="white--text" >
                        <h3 class="text-center ">Alredy Signed up?</h3>
                        <h6
                          class="text-center"
                        >Log in to your account so you can continue building and<br>  editing your onboarding flows</h6>
                      </v-card-text>
                      <div class="text-center">
                        <v-btn tile outlined dark @click="step--">Log in</v-btn>
                      </div>
                      </div>
                    </v-col>

                    <v-col cols="12" md="6">
                      <v-card-text class="mt-12">
                        <h4
                          class="text-center"
                        >Sign Up for an Account</h4>
                        <h6
                          class="text-center  grey--text "
                        >Let's get you all set up so you can start creatin your <br>
                        first onboarding experiance</h6>
                        <v-row align="center" justify="center">
                          <v-col cols="12" sm="8">
                           <v-row>
                           <v-col cols="12" sm="12">
                            <v-text-field
                            label="Name"
                            v-model="form.name"
                            outlined
                            dense
                            color="blue"
                            autocomplete="false"
                           class="mt-4"
                          />
                           </v-col>
                           </v-row>
                          <v-text-field
                            label="Email"
                            v-model="form.email"
                            outlined
                            dense
                            color="blue"
                            autocomplete="false"
                          />
                          <v-text-field
                            label="Password"
                            v-model="form.password"
                            @keyup.enter="register"
                            outlined
                            dense
                            color="blue"
                            autocomplete="false"
                            type="password"
                          
                          />
                            <v-row>
                              <v-col cols="12" sm="7">
                                <v-checkbox
                       
                                  label="I Accept AAE"
                                  class="mt-n1"
                                  color="blue"
                                > </v-checkbox>
                              </v-col>
                              <v-col cols="12" sm="5">
                                <span class="caption blue--text ml-n4">Terms &Conditions</span>
                              </v-col>
                            </v-row>
                          <v-btn color="blue" dark block tile @click="register" :loading="loading">Sign up</v-btn>
                     
                         <h5
                          class="text-center  grey--text mt-4 mb-3"
                        >Or Sign up using</h5>
                         <div class="d-flex  justify-space-between align-center mx-10 mb-11">
                        <v-btn depressed outlined color="grey">
                          <v-icon color="red">fab fa-google</v-icon>
                        </v-btn>
                        <v-btn depressed outlined color="grey">
                          <v-icon color="blue">fab fa-facebook-f</v-icon>
                        </v-btn>
                        <v-btn depressed outlined color="grey">
                          <v-icon color="light-blue lighten-3">fab fa-twitter</v-icon>
                        </v-btn>
                         </div>
                          </v-col>
                        </v-row>  
                      </v-card-text>
                    </v-col>
                  </v-row>
                </v-window-item>
              </v-window>
            </v-card>
          </v-col>
      </v-row>
  </v-container>
</template>

<script>
import {mapState, mapActions} from 'vuex'

  export default {
   data: () => ({
    step: 1,
    form: {
      email : '',
      password : '',
      login : 1,
    }
  }),
  props: {
    source: String
  },
  methods: {
    ...mapActions('auth',['login']),
    register(){
      this.form.login = null
      this.form.register = true
      this.login(this.form)
    }
  },
  computed:{
    ...mapState('auth',['error','loading'])
  }

    
  }
</script>
<style scoped>
.v-application .rounded-bl-xl {
    border-bottom-left-radius: 300px !important;
}
.v-application .rounded-br-xl {
    border-bottom-right-radius: 300px !important;
}
</style>
