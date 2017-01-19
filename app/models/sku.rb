class Sku < ActiveRecord::Base
  include PgSearch
   pg_search_scope :search_for, against: %i(sku model brand), using: { tsearch: { prefix: true } }
end
