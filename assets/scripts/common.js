let userInfo = {
    name: 'shewa',
    age: 30,
    fullName: () => {
        console.log(`name is ${this.name} & age is ${this.age}`);
    }
}
userInfo.fullName();