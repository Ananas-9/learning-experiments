from django.contrib import admin
from django.shortcuts import get_object_or_404
from .models import Article, ArticleImage, Category
from .forms import ArticleImageForm


# Register your models here.
class CategoryAdmin(admin.ModelAdmin):
    # Додаємо 'slug' до відображення списку
    list_display = ('category', 'slug')

    # Додаємо 'slug' до полів форми
    fieldsets = (('', {
        'fields': ('category', 'slug'),
    }),)

    # Використовуємо prepopulated_fields для автозаповнення slug
    prepopulated_fields = {'slug': ('category',)}


class ArticleImageInline(admin.TabularInline):
    model = ArticleImage
    form = ArticleImageForm
    extra = 0
    fieldsets = (
        ('', {
            'fields': ('title', 'image',),
        }),)


class ArticleAdmin(admin.ModelAdmin):
    list_display = ('title', 'pub_date', 'slug', 'main_page')
    inlines = [ArticleImageInline]
    multiupload_form = True
    multiupload_list = False
    prepopulated_fields = {'slug': ('title',)}
    raw_id_fields = ('category',)  # Можливо, краще мати 'category' у fieldsets
    fieldsets = (('', {
        'fields': ('pub_date', 'title', 'description', 'main_page', 'category'),  # Додано category
    }),
                 ((u'Додатково'), {
                     'classes': ('grp-collapse grp-closed',),
                     'fields': ('slug',),
                 }),
                 )

    def delete_file(self, pk, request):
        '''
        Delete an image.
        '''
        obj = get_object_or_404(ArticleImage, pk=pk)
        return obj.delete()


admin.site.register(Category, CategoryAdmin)
admin.site.register(Article, ArticleAdmin)