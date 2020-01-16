<template>
	<view class="page">
		<view class="search-block">
			<view class="search-ico-wapper">
				<image src="../../static/icos/search.png" mode="" class="search-ico"></image>
			</view>
			<input placeholder="" maxlength="10" class="search-text" focus>
		</view>
		<view class="movie-list page-block">
			<view class="movie-wapper" v-for="(trailer,index) in tailerList" :key="index">
				<image :src="trailer.cover" mode="" class="poster"></image>
			</view>
		</view>
	</view>
	
	
</template>

<script>
	import common from "../../common/common.js"
	export default {
		data() {
			return {
				tailerList:[]
			}
		},
		onLoad(){
			uni.showLoading({
				mask:true,
				title:"请稍后"
			})
			
			var serverUrl=common.serverUrl;
			//查询猜你喜欢
			uni.request({
			    url: serverUrl+'/search/index', 
			    method:"GET",
				success: (res) => {//箭头函数不需要_this
			        //console.log(res.data);
					if(res.data.code==200){
						var tailerList=res.data.data.items;
						this.tailerList=tailerList;
					}
			    },complete() {
					uni.hideLoading();
			    }
			});
		},
		methods: {
			
		}
	}
</script>

<style>
	@import url("search.css");
</style>
