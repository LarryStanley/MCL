@extends("dashboard/dashboardLayout")

@section("dashboardContent")
<style type="text/css"> 
	.check_lst{position:absolute;top:7%;left:50%;width:65%;height:50%;margin-left:-35%}
	.check_lst li{float:left;position:relative;width:20%;height:10%;overflow:hidden}
	.check_lst .on {background-color:#ffd28b;border-color:#fff200}
	.check_lst .inp_bx{margin-left:4%;margin-bottom:1.5%}
	.inp{position:absolute;left:-100px;top:0}
	.inp_lab{display:block;position:absolute;top:0;left:0;right:0;bottom:0;color:#554614;text-align:center;font-size:15px;font-weight:bold;}
</style>
<h1>大一勞服時間填寫</h1>
<hr>
<div style="position:relative">
	<ul class="check_lst">
		<li id="11">
			<div class="inp_bx">
				<label class="inp_lab">11</label>
				<input type="checkbox" id="w1" class="inp">
			</div>
		</li>
		<li id="21">
			<div class="inp_bx">
				<label class="inp_lab">21</label>
				<input type="checkbox" id="w2" class="inp">
			</div>
		</li>
		<li id="31">
			<div class="inp_bx">
				<label class="inp_lab">31</label>
				<input type="checkbox" id="w3" class="inp">
			</div>
		</li>
		<li id="41">
			<div class="inp_bx">
				<label class="inp_lab">41</label>
				<input type="checkbox" id="w4" class="inp">
			</div>
		</li>
		<li id="51">
			<div class="inp_bx">
				<label class="inp_lab">51</label>
				<input type="checkbox" id="w5" class="inp">
			</div>
		</li>
		<li id="12">
			<div class="inp_bx">
				<label class="inp_lab">12</label>
				<input type="checkbox" id="w6" class="inp">
			</div>
		</li>
		<li id="22">
			<div class="inp_bx">
				<label class="inp_lab">22</label>
				<input type="checkbox" id="w7" class="inp">
			</div>
		</li>
		<li id="32">
			<div class="inp_bx">
				<label class="inp_lab">32</label>
				<input type="checkbox" id="w8" class="inp">
			</div>
		</li>
		<li id="42">
			<div class="inp_bx">
				<label class="inp_lab">42</label>
				<input type="checkbox" id="w9" class="inp">
			</div>
		</li>
		<li id="52">
			<div class="inp_bx">
				<label class="inp_lab">52</label>
				<input type="checkbox" id="w10" class="inp">
			</div>
		</li>
		<li id="13">
			<div class="inp_bx">
				<label class="inp_lab">13</label>
				<input type="checkbox" id="w11" class="inp">
			</div>
		</li>
		<li id="23">
			<div class="inp_bx">
				<label class="inp_lab">23</label>
				<input type="checkbox" id="w12" class="inp">
			</div>
		</li>
		<li id="33">
			<div class="inp_bx">
				<label class="inp_lab">33</label>
				<input type="checkbox" id="w13" class="inp">
			</div>
		</li>
		<li id="43">
			<div class="inp_bx">
				<label class="inp_lab">43</label>
				<input type="checkbox" id="w14" class="inp">
			</div>
		</li>
		<li id="53">
			<div class="inp_bx">
				<label class="inp_lab">53</label>
				<input type="checkbox" id="w15" class="inp">
			</div>
		</li>
		<li id="14">
			<div class="inp_bx">
				<label class="inp_lab">14</label>
				<input type="checkbox" id="w16" class="inp">
			</div>
		</li>
		<li id="24">
			<div class="inp_bx">
				<label class="inp_lab">24</label>
				<input type="checkbox" id="w17" class="inp">
			</div>
		</li>
		<li id="34">
			<div class="inp_bx">
				<label class="inp_lab">34</label>
				<input type="checkbox" id="w18" class="inp">
			</div>
		</li>
		<li id="44">
			<div class="inp_bx">
				<label class="inp_lab">44</label>
				<input type="checkbox" id="w19" class="inp">
			</div>
		</li>
		<li id="54">
			<div class="inp_bx">
				<label class="inp_lab">54</label>
				<input type="checkbox" id="w20" class="inp">
			</div>
		</li>
		<li id="15">
			<div class="inp_bx">
				<label class="inp_lab">15</label>
				<input type="checkbox" id="w21" class="inp">
			</div>
		</li>
		<li id="25">
			<div class="inp_bx">
				<label class="inp_lab">25</label>
				<input type="checkbox" id="w22" class="inp">
			</div>
		</li>
		<li id="35">
			<div class="inp_bx">
				<label class="inp_lab">35</label>
				<input type="checkbox" id="w23" class="inp">
			</div>
		</li>
		<li id="45">
			<div class="inp_bx">
				<label class="inp_lab">45</label>
				<input type="checkbox" id="w24" class="inp">
			</div>
		</li>
		<li id="55">
			<div class="inp_bx">
				<label class="inp_lab">55</label>
				<input type="checkbox" id="w25" class="inp">
			</div>
		</li>
		<li id="1Z">
			<div class="inp_bx">
				<label class="inp_lab">1Z</label>
				<input type="checkbox" id="w26" class="inp">
			</div>
		</li>
		<li id="2Z">
			<div class="inp_bx">
				<label class="inp_lab">2Z</label>
				<input type="checkbox" id="w27" class="inp">
			</div>
		</li>
		<li id="3Z">
			<div class="inp_bx">
				<label class="inp_lab">3Z</label>
				<input type="checkbox" id="w28" class="inp">
			</div>
		</li>
		<li id="4Z">
			<div class="inp_bx">
				<label class="inp_lab">4Z</label>
				<input type="checkbox" id="w29" class="inp">
			</div>
		</li>
		<li id="5Z">
			<div class="inp_bx">
				<label class="inp_lab">5Z</label>
				<input type="checkbox" id="w30" class="inp">
			</div>
		</li>
		<li id="16">
			<div class="inp_bx">
				<label class="inp_lab">16</label>
				<input type="checkbox" id="w31" class="inp">
			</div>
		</li>
		<li id="26">
			<div class="inp_bx">
				<label class="inp_lab">26</label>
				<input type="checkbox" id="w32" class="inp">
			</div>
		</li>
		<li id="36">
			<div class="inp_bx">
				<label class="inp_lab">36</label>
				<input type="checkbox" id="w33" class="inp">
			</div>
		</li>
		<li id="46">
			<div class="inp_bx">
				<label class="inp_lab">46</label>
				<input type="checkbox" id="w34" class="inp">
			</div>
		</li>
		<li id="56">
			<div class="inp_bx">
				<label class="inp_lab">56</label>
				<input type="checkbox" id="w35" class="inp">
			</div>
		</li>
		<li id="17">
			<div class="inp_bx">
				<label class="inp_lab">17</label>
				<input type="checkbox" id="w36" class="inp">
			</div>
		</li>
		<li id="27">
			<div class="inp_bx">
				<label class="inp_lab">27</label>
				<input type="checkbox" id="w37" class="inp">
			</div>
		</li>
		<li id="37">
			<div class="inp_bx">
				<label class="inp_lab">37</label>
				<input type="checkbox" id="w38" class="inp">
			</div>
		</li>
		<li id="47">
			<div class="inp_bx">
				<label class="inp_lab">47</label>
				<input type="checkbox" id="w39" class="inp">
			</div>
		</li>
		<li id="57">
			<div class="inp_bx">
				<label class="inp_lab">57</label>
				<input type="checkbox" id="w40" class="inp">
			</div>
		</li>
		<li id="18">
			<div class="inp_bx">
				<label class="inp_lab">18</label>
				<input type="checkbox" id="w41" class="inp">
			</div>
		</li>
		<li id="28">
			<div class="inp_bx">
				<label class="inp_lab">28</label>
				<input type="checkbox" id="w42" class="inp">
			</div>
		</li>
		<li id="38">
			<div class="inp_bx">
				<label class="inp_lab">38</label>
				<input type="checkbox" id="w43" class="inp">
			</div>
		</li>
		<li id="48">
			<div class="inp_bx">
				<label class="inp_lab">48</label>
				<input type="checkbox" id="w44" class="inp">
			</div>
		</li>
		<li id="58">
			<div class="inp_bx">
				<label class="inp_lab">58</label>
				<input type="checkbox" id="w45" class="inp">
			</div>
		</li>
		<li id="19">
			<div class="inp_bx">
				<label class="inp_lab">19</label>
				<input type="checkbox" id="w46" class="inp">
			</div>
		</li>
		<li id="29">
			<div class="inp_bx">
				<label class="inp_lab">29</label>
				<input type="checkbox" id="w47" class="inp">
			</div>
		</li>
		<li id="39">
			<div class="inp_bx">
				<label class="inp_lab">39</label>
				<input type="checkbox" id="w48" class="inp">
			</div>
		</li>
		<li id="49">
			<div class="inp_bx">
				<label class="inp_lab">49</label>
				<input type="checkbox" id="w49" class="inp">
			</div>
		</li>
		<li id="59">
			<div class="inp_bx">
				<label class="inp_lab">59</label>
				<input type="checkbox" id="w50" class="inp">
			</div>
		</li>
		<li id="1A">
			<div class="inp_bx">
				<label class="inp_lab">1A</label>
				<input type="checkbox" id="w51" class="inp">
			</div>
		</li>
		<li id="2A">
			<div class="inp_bx">
				<label class="inp_lab">2A</label>
				<input type="checkbox" id="w52" class="inp">
			</div>
		</li>
		<li id="3A">
			<div class="inp_bx">
				<label class="inp_lab">3A</label>
				<input type="checkbox" id="w53" class="inp">
			</div>
		</li>
		<li id="4A">
			<div class="inp_bx">
				<label class="inp_lab">4A</label>
				<input type="checkbox" id="w54" class="inp">
			</div>
		</li>
		<li id="5A">
			<div class="inp_bx">
				<label class="inp_lab">5A</label>
				<input type="checkbox" id="w55" class="inp">
			</div>
		</li>
		<li id="1B">
			<div class="inp_bx">
				<label class="inp_lab">1B</label>
				<input type="checkbox" id="w56" class="inp">
			</div>
		</li>
		<li id="2B">
			<div class="inp_bx">
				<label class="inp_lab">2B</label>
				<input type="checkbox" id="w57" class="inp">
			</div>
		</li>
		<li id="3B">
			<div class="inp_bx">
				<label class="inp_lab">3B</label>
				<input type="checkbox" id="w58" class="inp">
			</div>
		</li>
		<li id="4B">
			<div class="inp_bx">
				<label class="inp_lab">4B</label>
				<input type="checkbox" id="w59" class="inp">
			</div>
		</li>
		<li id="5B">
			<div class="inp_bx">
				<label class="inp_lab">5B</label>
				<input type="checkbox" id="w60" class="inp">
			</div>
		</li>
		<li id="1C">
			<div class="inp_bx">
				<label class="inp_lab">1C</label>
				<input type="checkbox" id="w61" class="inp">
			</div>
		</li>
		<li id="2C">
			<div class="inp_bx">
				<label class="inp_lab">2C</label>
				<input type="checkbox" id="w62" class="inp">
			</div>
		</li>
		<li id="3C">
			<div class="inp_bx">
				<label class="inp_lab">3C</label>
				<input type="checkbox" id="w63" class="inp">
			</div>
		</li>
		<li id="4C">
			<div class="inp_bx">
				<label class="inp_lab">4C</label>
				<input type="checkbox" id="w64" class="inp">
			</div>
		</li>
		<li id="5C">
			<div class="inp_bx">
				<label class="inp_lab">5C</label>
				<input type="checkbox" id="w65" class="inp">
			</div>
		</li>
	</ul>
</div>
<button onclick="send()">送出</button>

<script>
	var times = 0;
	var date_array = [];
	Array.prototype.remove = function() {
	    var what, a = arguments, L = a.length, ax;
	    while (L && this.length) {
	        what = a[--L];
	        while ((ax = this.indexOf(what)) !== -1) {
	            this.splice(ax, 1);
	        }
	    }
	    return this;
	};

	$(document).ready(function() {
		$('.inp_bx').click(function() {
			if( !( $(this).parent().hasClass("on") )){
				if(times > 5 ){
					alert("不能選超過6個時段");
				}else{
					//$('.inp_bx').parent().removeClass('on');
					$(this).parent().addClass('on');
					date_array.push($(this).parent().attr('id'));
					times = times + 1 ;
					alert(date_array);
				}
			}else{
				date_array.remove($(this).parent().attr('id'));
				times = times - 1 ;
				$(this).parent().removeClass('on');
				alert(date_array);
			}
		});
	});

	function send() {
		$.ajax({
			url : 'url',
			type : 'POST',
			data: {
				date : date_array
				},
			dataType : 'json',
			success : function(data) {
			},
			error : function() {				
				alert('處理失敗，請稍候再試');
			},
			complete : function() {
			
			}
		});
		return;
	}
</script>
@stop