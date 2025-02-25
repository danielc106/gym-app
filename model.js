'use strict';

class Model {
    constructor() {
        this.nearbyGyms = [];
        this.age = 0;
        this.height = 0;
        this.weight = 0;
        this.gender = "";
        this.activity = "none";
    }
    addToNearbyGyms(gym, location){
        this.nearbyGyms.push(gym);
        this.nearbyGyms.push(location);
    }
    getNearbyGyms(){
        return this.nearbyGyms;
    }
    setAge(age){
        this.age=age;
    }
    getAge(){
        return this.age;
    }
    setHeight(height){
        this.height=height;
    }
    getHeight(){
        return this.height;
    }
    setWeight(weight){
        this.weight=weight;
    }
    getWeight(){
        return this.weight;
    }

    setGender(gender){
        this.gender = gender;
    }

    getGender(){
        return this.gender;
    }

    setActivity(act){
        this.activity = act;
    }

    getActivity(){
        return this.activity;
    }
}
