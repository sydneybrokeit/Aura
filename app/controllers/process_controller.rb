class ProcessController < ApplicationController
  def submit
    sku = Sku.new
    sku.jsonData = "asdasdyoyo"
    @data = params
    sku.save
  end
end
