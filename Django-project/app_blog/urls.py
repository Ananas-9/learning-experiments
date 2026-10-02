from django.urls import path
from app_blog import views
from app_blog.views import ArticleCategoryList, ArticleDetail, ArticleList

urlpatterns = [
    path(r'', views.HomePageView.as_view(), name='home'),
    path(r'articles', ArticleList.as_view(), name='articles-list'),
    path(r'articles/category/<slug>',ArticleCategoryList.as_view(), name='articles-category-list'),
    path(r'articles/<year>/<month>/<day>/<slug>', ArticleDetail.as_view(),name='article-detail'),
]