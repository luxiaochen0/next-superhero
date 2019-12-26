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
		
		<view class="page-block super-hot">
			<view class="hot-title-wapper">
				<image src="../../static/icos/hot.png" mode="" class="hot-ico"></image>
				<view class="hot-title">
					热门
				</view>
			</view>
		</view>
		
		<scroll-view scroll-x="true" class="page-block hot">
			<view class="single-poster">
				<view class="poster-wapper">
					<image src="../../static/poster/civilwar.jpg" mode="" class="poster"></image>
					<view class="movie-name">
						蝙蝠侠蝙蝠侠蝙蝠侠
					</view>
					<view class="movie-score-wapper">
						<image src="../../static/icos/star-yellow.png" mode="" class="star-ico"></image>
						<image src="../../static/icos/star-yellow.png" mode="" class="star-ico"></image>
						<image src="../../static/icos/star-yellow.png" mode="" class="star-ico"></image>
						<image src="../../static/icos/star-yellow.png" mode="" class="star-ico"></image>
						<image src="../../static/icos/star-gray.png" mode="" class="star-ico"></image>
						<view class="movie-score">
							9.0
						</view>
					</view>
				</view>
			</view>
		</scroll-view>
		
	</view>
</template>

<script>
	import common from "../../common/common.js"
	export default {
		data() {
			return {
				carouselList: []
			}
		},
		onLoad() {
			//var _this=this;
			var serverUrl=common.serverUrl;
			//请求轮播图数据
			uni.request({
			    url: serverUrl+'/index-carousel-list.json', 
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
