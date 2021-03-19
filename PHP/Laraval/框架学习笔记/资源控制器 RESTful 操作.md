# 资源控制器RESTful操作

Finish！

## 简介
这是 RESTful 风格的网站访问形式

## 自动生成资源类型的控制器(控制器里面会有相关的CRUD方法)：
php artisan make:controller PhotoController --resource

## 设置路由：
Route::resource('photos', 'PhotoController');

## 包括的方法：
index、create、store、show、edit、update、destroy


动作 | URI | 操作 | 路由名称
-- | -- | -- | --
GET | /photos | index | photos.index
GET | /photos/create | create | photos.create
POST | /photos | store | photos.store
GET | /photos/{photo} | show | photos.show
GET | /photos/{photo}/edit | edit | photos.edit
PUT/PATCH | /photos/{photo} | update | photos.update
DELETE | /photos/{photo} | destroy | photos.destroy

