document.addEventListener("plusready", function() {
	plus.geolocation.getCurrentPosition( function(p){
		var $lon=p.coords.longitude;
		var $lat=p.coords.latitude;
		mui.get("http://api.map.baidu.com/geocoder/v2/?ak=ezeKCOj1FQIWo6uuL056YYk9&location="+p.coords.latitude+","+p.coords.longitude+"&output=json&pois=1",{},
		function(data) {
			if(data.status==0){
				var $local=data.result.addressComponent.city+data.result.addressComponent.district;
				plus.storage.setItem("lat", String($lat));
				plus.storage.setItem("lon", String($lon));
				plus.storage.setItem("province", data.result.addressComponent.province);
				plus.storage.setItem("area", data.result.addressComponent.district);
				plus.storage.setItem("city", data.result.addressComponent.city);
				plus.storage.setItem("local", $local);
				mui.post('http://vali.wedams.com/ajax/userinfo_update_local.php',
				{pho:plus.storage.getItem('pho'),lat:$lat,lon:$lon,province:data.result.addressComponent.province,city:data.result.addressComponent.district,area:data.result.addressComponent.city},
				function(data){
					plus.nativeUI.toast(data.msg);
				},'json')
			}
			},'json');
	},function(){},{provider:'baidu'});
})