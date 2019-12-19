/**
 * Theme: Montran Admin Template
 * Author: Coderthemes
 * Component: Editable
 * 
 */

(function ($) {

	'use strict';
	var getUrl = window.location;
	var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/" + getUrl.pathname.split('/')[2] + "/";







	// face_detect(1);


	// var options = new Object();
	// options.detect_all_feature_points = true;
	// (userId, url, x, y, width, height, options, callback)


	// 2 tag save
	//  (tagIds, userId, options, callback)
	// var optionsTS = new Object();
	// optionsTS.namespace = 'm-attendance';
	// optionsTS.detect_all_feature_points = true;
	// //emil
	// // var tagsave = client.tagsSave("TEMP_F@085d81613507ddb31546b9c200af008b_40ee577b9b98a_51.32_36.29_0_1", 'emil@m-attendance', optionsTS, callback)
	// //adit test
	// var tagsave = client.tagsSave("TEMP_F@04e555b472372f942fab2ea901b2030e_3b361a4b2f9bc_45.21_61.09_0_1", 'aditTest1@m-attendance', optionsTS, callback)

	// 3 Face Train
	// facesTrain = function (userIds, options, callback)
	// var optionsFT = new Object();
	// optionsFT.namespace = 'm-attendance';
	// optionsFT.detect_all_feature_points = true;
	// // var tagsave = client.facesTrain('emil@m-attendance', optionsFT, callback)
	// var tagsave = client.facesTrain('aditTest1@m-attendance', optionsFT, callback)


	// 3 Face Recognize
	// this.facesRecognize = function (userIds, urls, files, options, callback)
	var optionsFR = new Object();
	optionsFR.namespace = 'm-attendance';
	optionsFR.detect_all_feature_points = true;
	// var faceRecog = client.facesRecognize('emil@m-attendance',  'https://scontent.fcgk18-2.fna.fbcdn.net/v/t1.0-9/13418888_10153944779383801_4480221177250522890_n.jpg?_nc_cat=104&_nc_eui2=AeHxLAGYalBEJvvurD2jT4HUUGWbz5fEal5zbwoFi2GGolq_wDdGuIyBSHWFqt-qJVV1yJXF4Q4fpj6KqbZQoMnfGxBb9AGePTGURMrwM7w9Vw&_nc_ht=scontent.fcgk18-2.fna&oh=c7457187efc0c7debcebef03cb7d98aa&oe=5D944DBD', null, optionsFR, callback)
	// var faceRecog = client.facesRecognize('emil@m-attendance',  'http://www.theplanetwow.com//assets/images/wow/emil.png', null, optionsFR, callback)
	// var faceRecog = client.facesRecognize('aditTest1@m-attendance',  'http://www.theplanetwow.com//assets/images/wow/ad1.jpg', null, optionsFR, callback)

	// client.tagsGet('aditya@m-attendance',"http://www.theplanetwow.com//assets/images/wow/aditya.png", '29.910000000000004', '26.625', '10', '50', options, callback)
	// client.tagsAdd('aditya@m-attendance',"http://www.theplanetwow.com//assets/images/wow/aditya.png", '29.910000000000004', '26.625', '10', '50', options, callback)

}).apply(this, [jQuery]);

var getUrl = window.location;
var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/" + getUrl.pathname.split('/')[2] + "/";

function drawFacesAddPoint(control, imgWidth, imgHeight, point, title) {
	var x = Math.round(point.x * imgWidth / 100);
	var y = Math.round(point.y * imgHeight / 100);
	var pointClass = title == null ? "api_face_all_point" : "api_face_point";
	var pointStyle = 'top: ' + y + 'px; left: ' + x + 'px;';
	var pointTitle = (title == null ? '' : title + ': ') + 'X=' + x + ', Y=' + y + ', Confidence=' + point.confidence + '%' + (title == null ? ', Id=' + point.id.toString(16) : '');
	control.append($('<span class="' + pointClass + '" style="' + pointStyle + '" title="' + pointTitle + '"></span>'));
}

function drawFaces(div, photo, drawPoints) {
	if (!photo) {
		alert("No image found");
		return;
	}
	if (photo.error_message) {
		alert(photo.error_message);
		return;
	}
	var imageWrapper = $('<div class="image_wrapper"></div>').appendTo(div);
	var maxImgWidth = parseInt(div.prev().children(".img_max_width").html(), 10);
	var maxImgHeight = parseInt(div.prev().children(".img_max_height").html(), 10);
	var imgWidth = photo.width;
	var imgHeight = photo.height;
	var scaleFactor = Math.min(maxImgWidth / imgWidth, maxImgHeight / imgHeight);
	if (scaleFactor < 1) {
		imgWidth = Math.round(imgWidth * scaleFactor);
		imgHeight = Math.round(imgHeight * scaleFactor);
	}
	imageWrapper.append($('<img alt="face detection results" width="' + imgWidth + 'px" height="' + imgHeight + 'px" src="' + photo.url + '" />'));
	if (photo.tags) {
		for (var i = 0; i < photo.tags.length; ++i) {
			var tag = photo.tags[i];
			var tagWidth = tag.width * 1.5;
			var tagHeight = tag.height * 1.5;
			var width = Math.round(tagWidth * imgWidth / 100);
			var height = Math.round(tagHeight * imgHeight / 100);
			var left = Math.round((tag.center.x - 0.5 * tagWidth) * imgWidth / 100);
			var top = Math.round((tag.center.y - 0.5 * tagHeight) * imgHeight / 100);
			if (drawPoints && tag.points) {
				for (var p = 0; p < tag.points.length; p++) {
					drawFacesAddPoint(imageWrapper, imgWidth, imgHeight, tag.points[p], null);
				}
			}
			var tagStyle = 'top: ' + top + 'px; left: ' + left + 'px; width: ' + width + 'px; height: ' + height + 'px; transform: rotate(' +
				tag.roll + 'deg); -ms-transform: rotate(' + tag.roll + 'deg); -moz-transform: rotate(' + tag.roll + 'deg); -webkit-transform: rotate(' +
				tag.roll + 'deg); -o-transform: rotate(' + tag.roll + 'deg)';
			var apiFaceTag = $('<div class="api_face" style="' + tagStyle + '"><div class="api_face_inner"><div class="api_face_inner_tid" name="' + tag.tid + '"></div></div></div>').appendTo(imageWrapper);
			if (drawPoints) {
				if (tag.eye_left) drawFacesAddPoint(imageWrapper, imgWidth, imgHeight, tag.eye_left, "Left eye");
				if (tag.eye_right) drawFacesAddPoint(imageWrapper, imgWidth, imgHeight, tag.eye_right, "Right eye");
				if (tag.mouth_center) drawFacesAddPoint(imageWrapper, imgWidth, imgHeight, tag.mouth_center, "Mouth center");
				if (tag.nose) drawFacesAddPoint(imageWrapper, imgWidth, imgHeight, tag.nose, "Nose tip");
			}
		}
	}
}

function callback(data, img, id, field) {
	console.log(data)
	// drawFaces($('.image1'), data.photos[0], true);
	var parseSend = {}
	parseSend['image_train_id'] = id;
	parseSend[field] = JSON.stringify(data);

	var url = "Mod_parliament/imageTrainEdit";
	
	if (field == 'face_detect') {

		$('.fd-td' + img).html('<i class="fa fa-check-square-o fd-check' + img + '" data-tid="' + data.photos[0].tags[0].tid + '"/>');
		var alrt = "Proses Face Detect Berhasil";

	} else if (field == 'tag') {

		parseSend['userid'] = $('.nama_anggota').val().replace(/ +/g, "") + id;
		$('.ts-td' + img).html('<i class="fa fa-check-square-o ts-check' + img + '" />');
		var alrt = "Proses Tag Save Berhasill";

	} else if (field == 'train') {

		$('.ft-td' + img).html('<i class="fa fa-check-square-o ft-check' + img + '" />');
		var alrt = "Proses Face Train Berhasil";

	} else if (field == 'recog') {

		// $('.ft-td' + img).html('<i class="fa fa-check-square-o ft-check' + img + '" />');
		var alrt = "recog result : " + data.photos[0].tags[0].confirmed;

	}

	// $.post(baseUrl + url, //Required URL of the page on server
		// parseSend,
		// function (response, status) { // Required Callback Function
			// alert("*----Received Data----*nnResponse : " + response + "nnStatus : " + status); //"response" receives - whatever written in echo of above PHP script.
			// $("#form")[0].reset();
			alert(alrt)
		// }
	// );
	// console.log(facedetect);
}

function face_detect(i, id) {
	// console.log($('.image' + i).attr('src'));
	var image = $('.image' + i).attr('src');
	// document.body.appendChild(image);
	console.log(image);

	// alert()
	var client = new FCClientJS('d0p5debv2gij5e0nlt7b5tq98c', '75lm13qfkds2ti0gfjj9kaelsb');
	var options = new Object();
	options.detect_all_feature_points = true;

	// 1 face detect
	var facedetect = client.facesDetect(image, null, options, callback, i, id, 'face_detect')

}

function tag_save(i, id) {
	// console.log($('.image' + i).attr('src'));
	var tid = $('.fd-check' + i).data('tid');
	var userId = $('.nama_anggota').val().replace(/ +/g, "") + id;

	//  (tagIds, userId, options, callback)

	// 2 Tag Save

	var client = new FCClientJS('d0p5debv2gij5e0nlt7b5tq98c', '75lm13qfkds2ti0gfjj9kaelsb');
	var optionsTS = new Object();
	optionsTS.namespace = 'm-attendance';
	optionsTS.detect_all_feature_points = true;

	var tagsave = client.tagsSave(tid, userId, optionsTS, callback, i, id, 'tag')

}

function face_train(i, id) {
	// console.log($('.image' + i).attr('src'));
	// var tid = $('.fd-check' + i).data('tid');
	var userId = $('.nama_anggota').val().replace(/ +/g, "") + id;

	//  (userIds, options, callback)

	// 3 Face Train

	var client = new FCClientJS('d0p5debv2gij5e0nlt7b5tq98c', '75lm13qfkds2ti0gfjj9kaelsb');
	var optionsFT = new Object();
	optionsFT.namespace = 'm-attendance';
	optionsFT.detect_all_feature_points = true;

	var tagsave = client.facesTrain(userId, optionsFT, callback, i, id, 'train')

}

// face_train('1', '1')

function face_recog(i, id) {
	// console.log($('.image' + i).attr('src'));
	// var tid = $('.fd-check' + i).data('tid');
	var userId = $('.nama_anggota').val().replace(/ +/g, "") + i;

	//  (userIds, options, callback)

	// 3 Face Train

	var client = new FCClientJS('d0p5debv2gij5e0nlt7b5tq98c', '75lm13qfkds2ti0gfjj9kaelsb');

	var optionsFR = new Object();
	optionsFR.namespace = 'm-attendance';
	optionsFR.detect_all_feature_points = true;
	var faceRecog = client.facesRecognize("farhan2@m-attendance", 'http://attendance.teaq.co.id/assets/images/dewan/saya.jpeg', null, optionsFR, callback, i, id, 'recog')


}
