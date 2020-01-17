<template>
	<view class="page">
		<view class="search-block">
			<view class="search-ico-wapper">
				<image src="../../static/icos/search.png" mode="" class="search-ico"></image>
			</view>
			<input placeholder="搜索预告" maxlength="10" class="search-text" confirm-type="search" @confirm="searchMe">
		</view>
		<view class="movie-list page-block">
			<view class="movie-wapper" v-for="(trailer,index) in trailerList" :key="index">
				<image :src="trailer.cover" mode="" class="poster" :data-trailerId="trailer.id" @click="showTrailer"></image>
			</view>
		</view>
	</view>
	
	
</template>

<script>
	import common from "../../common/common.js"
	export default {
		data() {
			return {
				trailerList:[],
				keywords:"",
				page_no:1,
				total_page:1
			}
		},
		onLoad(){
			this.pageTrailerList(this.keywords,1,15)
		},
		onReachBottom() {
			var page=this.page+1;//下一页
			var keywords=this.keywords;
			var total_page=this.total_page;
			if(page>total_page){
				return;
			}
			this.pageTrailerList(keywords,page,15);
		},
		methods: {
			pageTrailerList(keywords,page_no,page_size){
				uni.showLoading({
					mask:true,
					title:"请稍后"
				})
				
				var serverUrl=common.serverUrl;
				//查询猜你喜欢
				uni.request({
				    url: serverUrl+'/search/index', 
				    method:"GET",
					data:{keywords:keywords,page_no:page_no,page_size:page_size},
					success: (res) => {//箭头函数不需要_this
				        //console.log(res.data);
						if(res.data.code==200){
							var tempList=res.data.data.items;
							this.trailerList=this.trailerList.concat(tempList);
							this.total_page=res.data.data._meta.pageCount;
							this.page=page_no;
						}
				    },complete() {
						uni.hideLoading();
				    }
				});
			},
			searchMe(e){
				var value=e.detail.value;
				this.keywords=value;
				this.trailerList=[];
				
				this.pageTrailerList(value,1,15)
			},
			showTrailer(e){
				var trailerId=e.currentTarget.dataset.trailerid;
				uni.navigateTo({
					url:"../movie/movie?trailerId="+trailerId
				})
			}
		}
	}
</script>

<style>
	@import url("search.css");
</style>
