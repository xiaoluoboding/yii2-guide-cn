<h1 style="box-sizing: border-box; margin: 20px 0px 10px; font-size: 36px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: #333333; font-style: normal; font-variant: normal; letter-spacing: normal; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;">Overview</h1>
<p style="box-sizing: border-box; margin: 0px 0px 10px; color: #333333; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 20px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;">
	Yii applications are organized according to the
	<span class="Apple-converted-space">&nbsp;</span>
	<a style="box-sizing: border-box; color: #428bca; text-decoration: none; background: transparent;" href="http://wikipedia.org/wiki/Model-view-controller">model-view-controller (MVC)</a>
	<span class="Apple-converted-space">&nbsp;</span>
	design pattern.
	<span class="Apple-converted-space">&nbsp;</span>
	<a style="box-sizing: border-box; color: #428bca; text-decoration: none; background: transparent;" href="http://www.yiiframework.com/doc-2.0/guide-structure-models.html">Models</a>
	<span class="Apple-converted-space">&nbsp;</span>
	represent data, business logic and rules;
	<a style="box-sizing: border-box; color: #428bca; text-decoration: none; background: transparent;" href="http://www.yiiframework.com/doc-2.0/guide-structure-views.html">views</a>
	<span class="Apple-converted-space">&nbsp;</span>
	are output representation of models; and
	<span class="Apple-converted-space">&nbsp;</span>
	<a style="box-sizing: border-box; color: #428bca; text-decoration: none; background: transparent;" href="http://www.yiiframework.com/doc-2.0/guide-structure-controllers.html">controllers</a>
	<span class="Apple-converted-space">&nbsp;</span>
	take input and convert it to commands for
	<span class="Apple-converted-space">&nbsp;</span>
	<a style="box-sizing: border-box; color: #428bca; text-decoration: none; background: transparent;" href="http://www.yiiframework.com/doc-2.0/guide-structure-models.html">models</a>
	<span class="Apple-converted-space">&nbsp;</span>
	and
	<span class="Apple-converted-space">&nbsp;</span>
	<a style="box-sizing: border-box; color: #428bca; text-decoration: none; background: transparent;" href="http://www.yiiframework.com/doc-2.0/guide-structure-views.html">views</a>
	.
</p>
<p style="box-sizing: border-box; margin: 0px 0px 10px; color: #333333; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 20px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;">Besides MVC, Yii applications also have the following entities:</p>
<ul style="box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: #333333; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 20px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;">
	<li style="box-sizing: border-box;">
		<a style="box-sizing: border-box; color: #428bca; text-decoration: none; background: transparent;" href="http://www.yiiframework.com/doc-2.0/guide-structure-entry-scripts.html">entry scripts</a>
		: they are PHP scripts that are directly accessible by end users. They are responsible for starting a request handling cycle.
	</li>
	<li style="box-sizing: border-box;">
		<a style="box-sizing: border-box; color: #428bca; text-decoration: none; background: transparent;" href="http://www.yiiframework.com/doc-2.0/guide-structure-applications.html">applications</a>
		: they are globally accessible objects that manage application components and coordinate them to fulfill requests.
	</li>
	<li style="box-sizing: border-box;">
		<a style="box-sizing: border-box; color: #428bca; text-decoration: none; background: transparent;" href="http://www.yiiframework.com/doc-2.0/guide-structure-application-components.html">application components</a>
		: they are objects registered with applications and provide various services for fulfilling requests.
	</li>
	<li style="box-sizing: border-box;">
		<a style="box-sizing: border-box; color: #428bca; text-decoration: none; background: transparent;" href="http://www.yiiframework.com/doc-2.0/guide-structure-modules.html">modules</a>
		: they are self-contained packages that contain complete MVC by themselves. An application can be organized in terms of multiple modules.
	</li>
	<li style="box-sizing: border-box;">
		<a style="box-sizing: border-box; color: #428bca; text-decoration: none; background: transparent;" href="http://www.yiiframework.com/doc-2.0/guide-structure-filters.html">filters</a>
		: they represent code that need to be invoked before and after the actual handling of each request by controllers.
	</li>
	<li style="box-sizing: border-box;">
		<a style="box-sizing: border-box; color: #428bca; text-decoration: none; background: transparent;" href="http://www.yiiframework.com/doc-2.0/guide-structure-widgets.html">widgets</a>
		: they are objects that can be embedded in
		<span class="Apple-converted-space">&nbsp;</span>
		<a style="box-sizing: border-box; color: #428bca; text-decoration: none; background: transparent;" href="http://www.yiiframework.com/doc-2.0/guide-structure-views.html">views</a>
		. They may contain controller logic and can be reused in different views.
	</li>
</ul>
<p style="box-sizing: border-box; margin: 0px 0px 10px; color: #333333; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 20px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;">The following diagram shows the static structure of an application:</p>
<p style="box-sizing: border-box; margin: 0px 0px 10px; color: #333333; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 20px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;">&nbsp;</p>
<img style="box-sizing: border-box; border: 0px; vertical-align: middle;" src="http://xlbd.u.qiniudn.com/application-structure.png" alt="应用结构" /></p>