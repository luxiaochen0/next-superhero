<template>
	<view class="black">
		<image :src="cover" mode="widthFix" @longpress="operator"></image>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				cover:""
			}
		},
		onLoad(params) {
			uni.setNavigationBarColor({
				frontColor:"#ffffff",
				backgroundColor:"#000000"
			})
			
			var cover=params.cover;
			this.cover=cover;
		},
		methods: {
			operator(){
				uni.showActionSheet({
					itemList:["保存图片到本地","测试2","测试3"],
					success:(res)=>{
						if(res.tapIndex==0){
							uni.showLoading({
								title:"图片保存中"
							})
							uni.downloadFile({
								url:this.cover,
								success:(result)=>{
									var temp=result.tempFilePath;
									console.log(temp)
									uni.saveImageToPhotosAlbum({
										filePath:temp,
										success: () => {
											uni.showToast({
												title:"保存成功",
												duration:2000
											})
										},
										complete: () => {
											uni.hideLoading()
										}
									})
								}
							})
						}
					}
				})
			}
		}
	}
</script>

<style>
.black{
	background-color: #000000;
	width: 100%;
	height: 100%;
	display: flex;
	justify-content: center;
	align-items: center;
	position: fixed;
}
</style>
