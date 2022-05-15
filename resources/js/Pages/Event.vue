<template>
    <div class="calendar-wrapper">
        <div class="week-infomation">
            <div>Month: {{ curMonth}}</div>
            <div>Year: {{ curYear}}</div>
        </div>
        <div class="week-view" v-if="dates && dates.length > 0 ">
            <ul>
                <li v-for="i in dates">
                    <date-item :day="(i<10 ? '0'+i : i)+'.'+curMonth+'.'+curYear" @clickDate="addEvent"></date-item>
                </li>
            </ul>
        </div>
        <div class="navigator">
            <button class="prev" @click="changeDate('sub')">Prev week</button>
            <button class="next-week" @click="changeDate('add')">Next week</button>
        </div>
    </div>
</template>

<script>
    import DateItem from "../Components/Event/DateItem";
    import PopupEvent from "../Components/Event/PopupEvent";

    export default {
        name: "Event",
        components: {DateItem},
        data() {
            return {
                curYear: '',
                curMonth: '',
                dates: [],
                strCurDate: '',
                startOfWeek: '',
                lastDate: '',
                showPopup: true
            }
        },
        mounted() {
            this.updateWeek();
        },
        methods: {
            addEvent(day) {
                // not enough time for Modal, use Prompt instead
                let note = prompt("Add note for " + day, "Anniversary");
                if (confirm("Are you sure to add event '" + note + "' on " + day)) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "event/add", true);
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.send(JSON.stringify({
                        date: day,
                        note: note
                    }));
                }
            },
            updateWeek() {
                let date = new Date();
                if (!this.strCurDate) {
                    this.strCurDate = date;
                }
                this.startOfWeek = this.getLastSunday();
                this.curMonth = new Date(this.strCurDate).getMonth() + 1;
                this.curYear = new Date(this.strCurDate).getFullYear();
                this.renderDateList();
            },
            changeDate(action) {
                console.log(action);
                let d = new Date(this.strCurDate);
                if (action == 'sub') {
                    d.setDate(d.getDate() - 7);
                    this.strCurDate = d;
                    this.updateLastDateOfMonth();
                } else {
                    d.setDate(d.getDate() + 7);
                    this.strCurDate = d;
                }
                this.updateWeek();
            },
            renderDateList() {
                let dates = [];
                let vm = this;
                for (let i = 0; i < 7; i++) {
                    if (i + vm.startOfWeek > vm.lastDate) {
                        dates.push(i + vm.startOfWeek - vm.lastDate);
                    } else {
                        dates.push(i + vm.startOfWeek);
                    }
                }
                this.dates = dates;
                this.updateLastDateOfMonth();
            },
            updateLastDateOfMonth() {
                let date = new Date(this.strCurDate);
                let lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
                this.lastDate = lastDay.getDate();
            },
            getLastSunday() {
                const date = new Date(this.strCurDate);
                const today = date.getDate();
                const dayOfTheWeek = date.getDay();
                const newDate = date.setDate(today - (dayOfTheWeek || 7));
                return new Date(newDate).getDate() + 1;
            },

        }
    }
</script>

<style scoped>
    .week-view ul {
        width: 100px;
    }
</style>
