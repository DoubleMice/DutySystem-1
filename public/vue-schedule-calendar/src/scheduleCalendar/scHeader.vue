<template>
    <header class="schedule-calendar-hd">
        <button type="button"
                class="schedule-calendar-arrow double-arrow"
                @click="prevYear">&lt;&lt;</button>
        <button type="button"
                class="schedule-calendar-arrow"
                id="preMonth"
                @click="prevMonth">&lt;</button>
        <span class="schedule-calendar-display" id="now">{{year}}-{{month + 1}}</span>
        <button type="button"
                class="schedule-calendar-arrow"
                id="nextMonth"
                @click="nextMonth">&gt;</button>
        <button type="button"
                class="schedule-calendar-arrow double-arrow"
                @click="nextYear">&gt;&gt;</button>
        <button type="button" 
                data-toggle="modal" 
                data-target="#modal-switch-add"
                class="schedule-calendar-add" 
                id="addHoliday">添加假期</button>
        <button type="button" 
                data-toggle="modal" 
                data-target="#modal-switch-delete"
                class="schedule-calendar-delete" 
                id="deleteHoliday">删除假期</button>
    </header>
</template>
<script>
import { calcPrevMonth, calcNextMonth } from './utils'

export default {
    props: {
        year: Number,
        month: Number
    },
    computed: {

    },
    methods: {
        updateValue({ direction, year, month = this.month }) {
            this.$emit('updateValue', { year, month, direction })
        },
        prevYear() {
            this.updateValue({
                direction: 'Right',
                year: this.year - 1
            })
        },
        nextYear() {
            this.updateValue({
                direction: 'Left',
                year: this.year + 1
            })
        },
        prevMonth() {
            const { year, month } = calcPrevMonth(this.year, this.month)
            this.updateValue({
                direction: 'Right',
                year,
                month
            })
        },
        nextMonth() {
            const { year, month } = calcNextMonth(this.year, this.month)
            this.updateValue({
                direction: 'Left',
                year,
                month
            })
        },
        // addHoliday() {
            
        // }
    }
}
</script>
<style lang="less">
@import './variables.less';

.schedule-calendar- {
    &hd {
        display: flex;
        justify-content: center;
        align-content: center;
        align-items: center;
        height: @sc-header-height;
        padding: @sc-header-padding 0;
        font-size: @sc-header-fs;
        line-height: @sc-header-height - @sc-header-padding * 2;
        background: @sc-primary-color;
        color: @sc-body-color;
        user-select: none;
    }
    &arrow {
        font-family: consolas;
        font-size: inherit;
        font-weight: 400;
        padding: 0 10px;
        height: 100%;
        color: @sc-primary-light-color;
        border-radius: 2px;
        transition: .2s ease-in-out;

        &:hover {
            color: #fff;
            background: @sc-primary-dark-color
        }
        &:active {
            background: darken(@sc-primary-dark-color, 15%)
        }
        &.double-arrow {
            letter-spacing: -3px
        }
    }
    &display {
        padding: 0 1em;
        height: 100%;
    }
    &add {
        position: absolute;
        margin-left:35%;
        &:hover {
            color: #fff;
            background: @sc-primary-dark-color
        }
    }
    &delete {
        position: absolute;
        margin-left:45%;
        &:hover {
            color: #fff;
            background: @sc-primary-dark-color
        }
    } 
}
</style>
