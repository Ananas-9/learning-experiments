from django.test import TestCase
from django.urls import reverse

from app_blog.models import Category, Article

class CategoryModelTest(TestCase):
    @classmethod
    def setUpTestData(cls):
        Category.objects.create(category='Печиво', slug='pechivo')

    def test_articles_category_list_url(self):
        category = Category.objects.get(id=1)
        self.assertEqual(category.get_absolute_url(), '/articles/category/pechivo')


class ArticleModelTest(TestCase):
    @classmethod
    def setUpTestData(cls):
        cat1 = Category.objects.create(category='pechivo', slug='pechivo')
        Article.objects.create(category=cat1, title='Рецепт смачного печива', slug='recept-smachnogo-pechiva', pub_date='2020-01-01', main_page=False, description="Інгредієнти 1 2 3 4 5")

    def test_articles_details_url(self):
        article = Article.objects.get(id=1)
        self.assertEqual(article.get_absolute_url(), '/articles/2020/01/01/recept-smachnogo-pechiva')