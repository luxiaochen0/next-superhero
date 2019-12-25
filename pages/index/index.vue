<template>
	<view class="page">
		<swiper :indicator-dots="true" :autoplay="true" :interval="3000" :duration="1000">
			<!-- <swiper-item>
				<image src="../../static/carousel/batmanvssuperman.png" mode="" class="carousel"></image>
			</swiper-item>
			<swiper-item>
				<image src="../../static/carousel/spiderman.png" mode=""></image>
			</swiper-item> -->
			<swiper-item v-for="(carousel,index) in carouselList" :key=index>
				<image :src="carousel.image" mode="" class="carousel"></image>
			</swiper-item>
		</swiper>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				carouselList: []
			}
		},
		onLoad() {
			//var _this=this;
			//请求轮播图数据
			uni.request({
			    url: 'https://next-hero.oss-cn-shanghai.aliyuncs.com/json/index-carousel-list.json', 
			    method:"GET",
				success: (res) => {//箭头函数不需要_this
			        console.log(res.data);
					if(res.data.status==200){
						var carouselList=res.data.data;
						this.carouselList=carouselList;
					}
			    }
			});
		},
		methods: {

		}
	}
</script>

<style>
	@import url("index.css");
</style>
